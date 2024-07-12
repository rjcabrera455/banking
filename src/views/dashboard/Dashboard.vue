<script setup>
import { ref } from 'vue';
import DashboardCustomer from './DashboardCustomer.vue';
import DashboardAdmin from './DashboardAdmin.vue';
const userType = ref('Admin');
</script>

<template>
    <DashboardCustomer v-if="userType == 'Customer'" />
    <DashboardAdmin v-else />
</template>
