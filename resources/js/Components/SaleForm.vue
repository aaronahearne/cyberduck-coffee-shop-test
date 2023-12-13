<script setup>

import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, watch} from "vue";
import {router, useForm} from "@inertiajs/vue3";

defineProps({
    errors: Object,
});

const processing = ref(false);

const form = useForm({
    quantity: 0,
    unit_cost: '0.00',
});

const sellingPrice = ref(0);

watch(() => [form.quantity, form.unit_cost], () => {
    calculateSellingPrice();
});

const submit = () => {
    if (processing.value || form.quantity < 1 || form.unit_cost < 0.01) {
        return;
    }

    processing.value = true;

    router.post(
        route('sale.store'),
        form,
        {
            preserveScroll: true,
            onSuccess: () => {
                form.quantity = 0;
                form.unit_cost = '0.00';
                sellingPrice.value = 0;
            },
            onFinish: () => {
                processing.value = false;
            },
        }
    );
};

const calculateSellingPrice = async () => {
    if (form.quantity < 1 || form.unit_cost < 0.01) {
        sellingPrice.value = 0;
        return;
    }

    await axios.post(route('sale.calculate'), form).then((response) => {
        sellingPrice.value = response.data.selling_price;
    }).catch((error) => {
        console.log(error);
    });
};

</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid grid-cols-4">
            <div>
                <InputLabel for="quantity" value="Quantity"/>
                <TextInput
                    id="quantity"
                    type="number"
                    class="mt-1 block"
                    v-model="form.quantity"
                    min='0'
                    required
                />
                <InputError class="mt-2" :message="form.errors.quantity"/>
            </div>

            <div>
                <InputLabel for="unit_cost" value="Unit Cost (£)"/>
                <TextInput
                    id="unit_cost"
                    type="number"
                    class="mt-1 block"
                    v-model="form.unit_cost"
                    required
                    step='0.01'
                    min='0.00'
                    placeholder='0.00'
                />
                <InputError class="mt-2" :message="form.errors.unit_cost"/>
            </div>

            <div>
                <InputLabel value="Selling Price"/>
                <p class="my-2">{{ $filters.currency(sellingPrice) }}</p>
            </div>

            <div>
                <PrimaryButton
                    class="mt-6"
                    :class="{ 'opacity-25': processing.value }"
                    :disabled="processing.value">
                    Record Sale
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
