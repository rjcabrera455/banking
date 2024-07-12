<script setup>
import { reactive } from 'vue';

const form = reactive({
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    mobile_number: '',
    password: '',
    pin: null,
    beginning_balance: ''
});
</script>

<template>
    <div class="card">
        <h5>Create New Account</h5>
        <div class="p-fluid formgrid grid">
            <div class="field col-12 md:col-4">
                <label for="first_name">First Name <small class="p-error">*</small></label>
                <InputText id="first_name" type="text" v-model="form.first_name" />
            </div>

            <div class="field col-12 md:col-4">
                <label for="middle_name">Middle Name</label>
                <InputText id="middle_name" type="text" v-model="form.middle_name" />
            </div>

            <div class="field col-12 md:col-4">
                <label for="last_name">Last Name <small class="p-error">*</small></label>
                <InputText id="last_name" type="text" v-model="form.last_name" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="email">Email <small class="p-error">*</small></label>
                <InputText id="email" type="text" v-model="form.email" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="mobile_number">Mobile Number <small class="p-error">*</small></label>
                <InputText id="mobile_number" type="text" v-model="form.mobile_number" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="password">Password <small class="p-error">*</small></label>
                <Password v-model="form.password" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="pin">Pin <small class="p-error">*</small></label>
                <InputNumber v-model="form.pin" inputId="pin" />
            </div>
        </div>

        <div class="flex gap-3 mt-1">
            <Button label="Cancel" severity="secondary" outlined />
            <Button label="Create" />
        </div>
    </div>
</template>
