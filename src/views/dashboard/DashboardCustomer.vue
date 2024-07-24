<script setup>
import useHelper from '@/utils/helper';

import { ref } from 'vue';

const helper = useHelper();
const loading = ref(false);

defineProps({
    user: Object
});
</script>

<template>
    <div class="grid" v-if="loading">
        <div class="col">
            <div class="card px-4 border-0 shadow-1 text-center">
                <ProgressSpinner style="width: 30px; height: 30px" strokeWidth="8" fill="var(--surface-ground)" animationDuration=".5s" aria-label="Custom ProgressSpinner" />
            </div>
        </div>
    </div>
    <div class="card p-0 py-3 mb-4 border-0 shadow-1" v-else>
        <div class="flex align-items-center">
            <Image :src="helper.getProfile(user?.profile)" height="80" width="80" preview class="ml-3 mr-3 border-circle overflow-hidden" />

            <div>
                <h4 class="m-0 text-500 font-medium">{{ user?.full_name }}</h4>
                <p class="mb-0 fs-5 text-500">
                    Account Number: <strong>{{ user?.account_number }}</strong>
                </p>
                <p class="mb-0 fs-5 text-500">
                    Current Balance: <strong>{{ user?.balance }}</strong>
                </p>
            </div>
        </div>
    </div>
</template>
