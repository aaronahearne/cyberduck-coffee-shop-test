<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import SalesTable from "@/Components/SalesTable.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";

defineProps({
    sales: {
        type: Array,
    },
});

const form = useForm({
    quantity: 0,
    unit_cost: 0,
});

const submitF = () => {
    form.post(route('sale.store'));
};

</script>

<template>
    <Head title="Coffee Shop"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <Card>
            <form @submit.prevent="submitF">
                <div>
                    <InputLabel for="quantity" value="Quantity"/>
                    <TextInput
                        id="quantity"
                        type="text"
                        class="mt-1 block"
                        v-model="form.quantity"
                        required
                    />

                    <InputLabel for="unit_cost" value="Unit Cost"/>
                    <TextInput
                        id="unit_cost"
                        type="number"
                        class="mt-1 block"
                        v-model="form.unit_cost"
                        required
                    />

                    <InputError class="mt-2" :message="form.errors.quantity"/>
                </div>

                <PrimaryButton class="m-4" :class="{ 'opacity-25': form.processing }"
                               :disabled="form.processing">
                    Record Sale
                </PrimaryButton>
            </form>
        </Card>

        <Card>
            <SalesTable :sales="sales"/>
        </Card>

    </AuthenticatedLayout>
</template>
