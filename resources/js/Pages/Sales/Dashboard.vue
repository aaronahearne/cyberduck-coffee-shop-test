<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import SalesTable from "@/Components/SalesTable.vue";
import Card from "@/Components/Card.vue";
import SaleForm from "@/Components/SaleForm.vue";

defineProps({
    sales: {
        type: Array,
    },
    errors: Object
});
</script>

<template>
    <Head title="Coffee Shop"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">New ☕️️ Sales</h2>
        </template>

        <Card>
            <SaleForm :errors="errors"/>
        </Card>

        <Card>
            <SalesTable :sales="sales"/>
        </Card>

    </AuthenticatedLayout>
</template>
