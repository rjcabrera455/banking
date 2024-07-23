<script setup>
import DashboardCustomer from './DashboardCustomer.vue';
import DashboardAdmin from './DashboardAdmin.vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
</script>

<template>
    <DashboardCustomer v-if="authStore.user.role == 'Customer'" />
    <DashboardAdmin v-else />
</template>
