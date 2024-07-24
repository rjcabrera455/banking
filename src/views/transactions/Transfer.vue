<script setup>
import { reactive, ref, watch } from 'vue';
import useToast from '@/utils/toast';
import { useAuthStore } from '@/stores/auth';
import transactionService from '@/service/transactionService';
import ValidationErrorMessage from '@/components/ValidationErrorMessage.vue';
import { RouterLink } from 'vue-router';

const toast = useToast();
const authStore = useAuthStore();

const submitting = ref(false);
const errors = ref([]);
const isDisabled = ref(true);

const account = reactive({
    account_number: '',
    balance: 0
});

const form = reactive({
    amount: 0,
    receiver_account_number: '',
    receiver_name: ''
});

function transfer() {
    submitting.value = true;
    errors.value = {};
    transactionService
        .transfer(form)
        .then((response) => {
            account.balance -= Number(form.amount);
            // form.receiver_account_number = 0;
            // form.receiver_name = 0;
            form.amount = 0;
            toast.success(response.data.message);
        })
        .catch((error) => {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                toast.error(error.response.data.error, error.response.data.message);
            }
        })
        .finally(() => {
            submitting.value = false;
        });
}

function getReceiverDetails() {
    transactionService
        .getReceiverDetails({ account_number: form.receiver_account_number })
        .then((response) => {
            const data = response.data.data;
            form.receiver_name = data;
        })
        .catch((error) => {
            toast.error(error.response.data.error, error.response.data.message);
        });
}

watch(
    () => authStore.user,
    (newUser) => {
        if (newUser) {
            account.account_number = authStore.user?.account?.account_number;
            account.balance = Number(authStore.user?.account?.balance);
        }
    },
    { immediate: true }
);
</script>

<template>
    <div class="card border-0 shadow-1">
        <h5>Transfer</h5>
        <form action="" method="post" @submit.prevent="transfer">
            <div class="p-fluid formgrid grid">
                <div class="field col-12 md:col-6">
                    <label for="account-number">Your Account Number</label>
                    <InputText id="account-number" type="text" v-model="account.account_number" disabled />
                </div>
                <div class="field col-12 md:col-6">
                    <label for="current-balance">Your Current Balance</label>
                    <InputNumber v-model="account.balance" inputId="current-balance" :minFractionDigits="2" disabled />
                </div>

                <div class="field col-12 md:col-6">
                    <label for="receiver-account-number">Transfer to <small class="p-error">*</small></label>
                    <InputText id="receiver-account-number" type="text" v-model="form.receiver_account_number" placeholder="Enter receiver account number" />
                    <ValidationErrorMessage :error="errors?.receiver_account_number?.at(0)" />
                </div>
                <div class="field col-12 md:col-6">
                    <label for="receiver-name">Receiver Name </label>
                    <InputText id="receiver-name" type="text" v-model="form.receiver_name" />
                    <ValidationErrorMessage :error="errors?.receiver_name?.at(0)" />
                </div>

                <div class="field col-12">
                    <label for="amount">Amount <small class="p-error">*</small></label>
                    <InputText id="amount" type="text" v-model.trim="form.amount" :invalid="Boolean(errors?.amount?.at(0))" />
                    <ValidationErrorMessage :error="errors?.amount?.at(0)" />
                </div>
            </div>

            <div class="flex gap-3 mt-1">
                <RouterLink :to="{ name: 'dashboard' }">
                    <Button label="Cancel" severity="secondary" outlined />
                </RouterLink>
                <Button type="submit" label="Transfer" />
            </div>
        </form>
    </div>
</template>
