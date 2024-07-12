<script setup>
import useHelper from '@/utils/helper';

const helper = useHelper();
</script>

<template>
    <div class="card p-0 py-3 mb-4 border-0 shadow-1">
        <div class="flex align-items-center">
            <Image :src="helper.getProfile('')" height="80" width="80" preview class="ml-3 mr-3 border-circle overflow-hidden" />

            <div>
                <h4 class="m-0 text-500 font-medium">John Doe</h4>
                <p class="mb-0 fs-5 text-500">Account Number: <strong>123456789</strong></p>
                <p class="mb-0 fs-5 text-500">Current Balance: <strong>100,000</strong></p>
            </div>
        </div>
    </div>
</template>
