<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([]);

const userType = 'Client';

if (userType == 'Admin') {
    model.value = [
        {
            items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
        },
        {
            items: [{ label: 'Deposit', icon: 'pi pi-fw pi-money-bill', to: '#' }]
        },
        {
            items: [{ label: 'Transfer', icon: 'pi pi-fw pi-arrow-right-arrow-left', to: '#' }]
        },
        {
            items: [{ label: 'Withdraw', icon: 'pi pi-fw pi-credit-card ', to: '#' }]
        },
        {
            items: [{ label: 'Transaction History', icon: 'pi pi-history', to: '#' }]
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
                    items: [{ label: 'Transaction Report', to: '#' }]
                }
            ]
        },
        {
            items: [{ label: 'Users', icon: 'pi pi-users', to: '#' }]
        },
        {
            items: [{ label: 'Configurations', icon: 'pi pi-cog', to: '#' }]
        }
    ];
}
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
