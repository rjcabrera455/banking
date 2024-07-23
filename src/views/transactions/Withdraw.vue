<script setup>
import { reactive } from 'vue';

const account = reactive({
    account_number: '123456789',
    current_balance: 100000,
    amount: 0
});
</script>

<template>
    <div class="card">
        <h5>Withdraw</h5>
        <div class="p-fluid formgrid grid">
            <div class="field col-12 md:col-6">
                <label for="account-number">Your Account Number</label>
                <InputText id="account-number" type="text" v-model="account.account_number" disabled />
            </div>
            <div class="field col-12 md:col-6">
                <label for="current-balance">Your Current Balance</label>
                <InputNumber v-model="account.current_balance" inputId="current-balance" :minFractionDigits="2" disabled />
            </div>
            <div class="field col-12">
                <label for="age1">Amount <small class="p-error">*</small></label>
                <InputText id="age1" type="text" v-model="account.number" />
            </div>
        </div>

        <div class="flex gap-3 mt-1">
            <Button label="Cancel" severity="secondary" outlined />
            <Button label="Withdraw" />
        </div>
    </div>
</template>
