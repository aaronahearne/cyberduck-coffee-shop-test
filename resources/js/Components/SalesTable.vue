<script setup>
defineProps({
    sales: {
        type: Array,
    },
});

</script>

<template>
    <table class="table-auto w-full text-left">
        <thead>
        <tr>
            <th class="p-3">Product</th>
            <th class="p-3">Quantity</th>
            <th class="p-3">Unit Cost</th>
            <th class="p-3">Selling Price</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="sale in sales" class="hover:bg-stone-100">
            <td class="p-3">{{ sale.coffee.name }}</td>
            <td class="p-3">{{ sale.quantity }}</td>
            <td class="p-3">{{ $filters.currency(sale.unit_cost) }}</td>
            <td class="p-3">{{ $filters.currency(sale.selling_price) }}</td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
