<script setup>
import { onMounted, reactive, ref } from 'vue';
import accountService from '@/service/accountService';
import ValidationErrorMessage from '@/components/ValidationErrorMessage.vue';
import { useRouter } from 'vue-router';
import useToast from '@/utils/toast';

const toast = useToast();
const errors = ref({});
const router = useRouter();
const submitting = ref(false);

const form = reactive({
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    mobile_number: '',
    password: '',
    password_confirmation: '',
    pin: null
});

function addAccount() {
    submitting.value = true;
    errors.value = {};
    accountService
        .addAccount(form)
        .then((response) => {
            toast.success(response.data.message);
            router.push({ name: 'accounts.index' });
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
            form.password = '';
            form.password_confirmation = '';
        });
}
</script>

<template>
    <div class="card border-0 shadow-1">
        <h5>Create New Account</h5>
        <form action="" method="post" @submit.prevent="addAccount">
            <div class="p-fluid formgrid grid">
                <!-- First Name -->
                <div class="field col-12 md:col-4">
                    <label for="first_name">First Name <small class="p-error">*</small></label>
                    <InputText id="first_name" type="text" v-model.trim="form.first_name" :invalid="Boolean(errors?.first_name?.at(0))" />
                    <ValidationErrorMessage :error="errors?.first_name?.at(0)" />
                </div>

                <!-- Middle Name -->
                <div class="field col-12 md:col-4">
                    <label for="middle_name">Middle Name</label>
                    <InputText id="middle_name" type="text" v-model.trim="form.middle_name" :invalid="Boolean(errors?.middle_name?.at(0))" />
                    <ValidationErrorMessage :error="errors?.middle_name?.at(0)" />
                </div>

                <!-- Last Name -->
                <div class="field col-12 md:col-4">
                    <label for="last_name">Last Name <small class="p-error">*</small></label>
                    <InputText id="last_name" type="text" v-model.trim="form.last_name" :invalid="Boolean(errors?.last_name?.at(0))" />
                    <ValidationErrorMessage :error="errors?.last_name?.at(0)" />
                </div>

                <!-- Email -->
                <div class="field col-12 md:col-6">
                    <label for="email">Email <small class="p-error">*</small></label>
                    <InputText id="email" type="email" v-model.trim="form.email" :invalid="Boolean(errors?.email?.at(0))" />
                    <ValidationErrorMessage :error="errors?.email?.at(0)" />
                </div>

                <!-- Mobile Number -->
                <div class="field col-12 md:col-6">
                    <label for="mobile_number">Mobile Number <small class="p-error">*</small></label>
                    <InputText id="mobile_number" type="text" v-model.trim="form.mobile_number" :invalid="Boolean(errors?.mobile_number?.at(0))" />
                    <ValidationErrorMessage :error="errors?.mobile_number?.at(0)" />
                </div>

                <!-- Password -->
                <div class="field col-12 md:col-6">
                    <label for="password">Password <small class="p-error">*</small></label>
                    <Password v-model="form.password" :invalid="Boolean(errors?.password?.at(0))" :inputProps="{ autocomplete: true, id: 'password' }" />
                    <ValidationErrorMessage :error="errors?.password?.at(0)" />
                </div>

                <!-- Password Confirmation -->
                <div class="field col-12 md:col-6">
                    <label for="password_confirmation">Confirm Password <small class="p-error">*</small></label>
                    <Password v-model="form.password_confirmation" :invalid="Boolean(errors?.password_confirmation?.at(0))" :inputProps="{ autocomplete: true, id: 'password_confirmation' }" />
                    <ValidationErrorMessage :error="errors?.password_confirmation?.at(0)" />
                </div>

                <!-- Pin -->
                <div class="field col-12">
                    <label for="pin">Pin <small class="p-error">*</small></label>
                    <InputNumber v-model.trim="form.pin" inputId="pin" :useGrouping="false" :invalid="Boolean(errors?.pin?.at(0))" />
                    <ValidationErrorMessage :error="errors?.pin?.at(0)" />
                </div>
            </div>

            <div class="flex gap-3 mt-1">
                <RouterLink :to="{ name: 'dashboard' }">
                    <Button label="Cancel" severity="secondary" outlined />
                </RouterLink>
                <Button type="submit" label="Add" :loading="submitting" />
            </div>
        </form>
    </div>
</template>
