<script setup>
import useHelper from '@/utils/helper';

const helper = useHelper();
</script>

<template>
    <div class="grid">
        <!-- Total Accounts -->
        <div class="col-12 lg:col-6 xl:col-3">
            <div class="card mb-0 border-0 shadow-1">
                <div class="flex justify-content-between">
                    <div>
                        <span class="block text-500 font-medium mb-3">Accounts</span>
                        <div class="text-900 font-medium text-xl">152</div>
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
                        <div class="text-900 font-medium text-xl">152</div>
                    </div>
                    <div class="flex align-items-center justify-content-center bg-blue-100 border-round" style="width: 2.5rem; height: 2.5rem">
                        <i class="pi pi-money-bill text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
