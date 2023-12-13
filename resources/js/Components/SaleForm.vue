<script>

import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {onMounted, ref, watch} from "vue";
import {useForm} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";

export default {
    props: {
        coffees: Array,
    },
    components: {
        TextInput,
        InputLabel,
        InputError,
        PrimaryButton,
        Dropdown,
    },
    setup(props) {
        const form = useForm({
            quantity: 0,
            unit_cost: '0.00',
            coffee_id: 0,
        });
        const sellingPrice = ref(0);

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

        const submit = () => {
            if (form.processing || form.quantity < 1 || form.unit_cost < 0.01) {
                return;
            }

            form.post(route('sale.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    form.quantity = 0;
                    form.unit_cost = '0.00';
                    sellingPrice.value = 0;
                },
            });
        };

        onMounted(() => {
            if (props.coffees && props.coffees.length > 0) {
                form.coffee_id = props.coffees[0].id;
            }
        });

        watch(() => [form.quantity, form.unit_cost, form.coffee_id], () => {
            calculateSellingPrice();
        });

        return {
            form,
            sellingPrice,
            submit
        };
    },
};
</script>

<template>
    <form @submit.prevent="submit">
        <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-1">
            <div class="my-3">
                <InputLabel for="product" value="Product"/>
                <select
                    id="selectOption"
                    v-model="form.coffee_id"
                    class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:w-auto w-full"
                >
                    <option v-for="coffee in coffees" :key="coffee.name" :value="coffee.id">
                        {{ coffee.name }}
                    </option>
                </select>

                <InputError class="mt-2" :message="form.errors.coffee_id"/>
            </div>

            <div class="my-3">
                <InputLabel for="quantity" value="Quantity"/>
                <TextInput
                    id="quantity"
                    type="number"
                    class="mt-1 block sm:w-auto w-full"
                    v-model="form.quantity"
                    min='0'
                    required
                />
                <InputError class="mt-2" :message="form.errors.quantity"/>
            </div>

            <div class="my-3">
                <InputLabel for="unit_cost" value="Unit Cost (£)"/>
                <TextInput
                    id="unit_cost"
                    type="number"
                    class="mt-1 block sm:w-auto w-full"
                    v-model="form.unit_cost"
                    required
                    step='0.01'
                    min='0.00'
                    placeholder='0.00'
                />
                <InputError class="mt-2" :message="form.errors.unit_cost"/>
            </div>

            <div class="my-3">
                <InputLabel value="Selling Price"/>
                <p class="my-2 sm:w-auto w-full">{{ $filters.currency(sellingPrice) }}</p>
            </div>

            <div class="my-3">
                <PrimaryButton
                    class="mt-6 sm:w-auto w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Record Sale
                </PrimaryButton>
            </div>
        </div>
    </form>
</template>
