<script setup>
import { ref, watch } from 'vue';
import AppMenuItem from './AppMenuItem.vue';
import { useAuthStore } from '@/stores/auth';

const model = ref([]);
const loading = ref(true);
const authStore = useAuthStore();

const setMenuModel = (role) => {
    if (role === 'Customer') {
        model.value = [
            {
                items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
            },
            {
                items: [{ label: 'Deposit', icon: 'pi pi-fw pi-money-bill', to: '/transactions/deposit' }]
            },
            {
                items: [{ label: 'Transfer', icon: 'pi pi-fw pi-arrow-right-arrow-left', to: '/transactions/transfer' }]
            },
            {
                items: [{ label: 'Withdraw', icon: 'pi pi-fw pi-credit-card ', to: '/transactions/withdraw' }]
            },
            {
                items: [{ label: 'Transactions', icon: 'pi pi-history', to: '/transactions' }]
            }
        ];
    } else {
        model.value = [
            {
                items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
            },
            {
                icon: 'pi pi-fw pi-bookmark',
                items: [
                    {
                        label: 'Reports',
                        icon: 'pi pi-fw pi-chart-bar',
                        items: [{ label: 'Transaction Report', to: '/reports/transaction' }]
                    }
                ]
            },
            {
                items: [{ label: 'Accounts', icon: 'pi pi-credit-card', to: '/accounts' }]
            },
            {
                items: [{ label: 'Announcements', icon: 'pi pi-megaphone', to: '/announcements' }]
            },
            {
                items: [{ label: 'System Settings', icon: 'pi pi-cog', to: '/settings/system' }]
            }
        ];
    }
};

// Watch the user object for changes and set the menu model accordingly
watch(
    () => authStore.user,
    (newUser) => {
        if (newUser && newUser.role) {
            setMenuModel(newUser.role);
            loading.value = false;
        }
    },
    { immediate: true }
);
</script>

<template>
    <ul v-if="!loading" class="layout-menu">
        <template v-for="(item, i) in model" :key="i">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
    <div class="text-center my-5" v-else>
        <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
    </div>
</template>

<style lang="scss" scoped></style>
