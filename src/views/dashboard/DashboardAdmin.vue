<script setup>
import dashboardService from '@/service/dashboardService';
import { onMounted, ref } from 'vue';
import useToast from '@/utils/toast';

const loading = ref(false);
const toast = useToast();
const data = ref();

const getAdminDashboard = () => {
    loading.value = true;
    dashboardService
        .getAdminDashboard()
        .then((response) => {
            data.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
            toast.error(error.response.data.error, error.response.data.message);
        })
        .finally(() => {
            loading.value = false;
        });
};

onMounted(() => getAdminDashboard());
</script>

<template>
    <div class="grid" v-if="loading">
        <div class="col">
            <div class="card px-4 border-0 shadow-1 text-center">
                <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
            </div>
        </div>
    </div>
    <div class="grid" v-else>
        <!-- Total Accounts -->
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0 border-0 shadow-1">
                <div class="flex justify-content-between">
                    <div>
                        <span class="block text-500 font-medium mb-3">Accounts</span>
                        <div class="text-900 font-medium text-xl">{{ data?.total_accounts }}</div>
                    </div>
                    <div class="flex align-items-center justify-content-center bg-blue-100 border-round" style="width: 2.5rem; height: 2.5rem">
                        <i class="pi pi-credit-card text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0 border-0 shadow-1">
                <div class="flex justify-content-between">
                    <div>
                        <span class="block text-500 font-medium mb-3">Accounts Balance</span>
                        <div class="text-900 font-medium text-xl">{{ data?.total_account_balance }}</div>
                    </div>
                    <div class="flex align-items-center justify-content-center bg-blue-100 border-round" style="width: 2.5rem; height: 2.5rem">
                        <i class="pi pi-money-bill text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
