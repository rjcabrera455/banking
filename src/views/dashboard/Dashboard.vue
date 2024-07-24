<script setup>
import { ref } from 'vue';
import DashboardCustomer from './DashboardCustomer.vue';
import DashboardAdmin from './DashboardAdmin.vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
</script>

<template>
    <DashboardCustomer v-if="authStore.user.role == 'Customer'" :user="authStore.user" />
    <DashboardAdmin v-else />
</template>
