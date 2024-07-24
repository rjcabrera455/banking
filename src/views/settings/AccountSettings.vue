<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import settingService from '@/service/settingService';
import ValidationErrorMessage from '@/components/ValidationErrorMessage.vue';
import { useRoute, useRouter } from 'vue-router';
import useToast from '@/utils/toast';
import { useAuthStore } from '@/stores/auth';

const toast = useToast();
const authStore = useAuthStore();
const errors = ref({});
const router = useRouter();
const route = useRoute();
const submitting = ref(false);
const loading = ref(false);

const form = reactive({
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    mobile_number: '',
    password: '',
    password_confirmation: '',
    pin: null,
    profile: ''
});

watch(
    () => authStore.user,
    (newUser) => {
        if (newUser) {
            form.first_name = authStore.user?.first_name;
            form.middle_name = authStore.user?.middle_name;
            form.last_name = authStore.user?.last_name;
            form.email = authStore.user?.email;
            form.mobile_number = authStore.user?.mobile_number;
            form.pin = authStore.user?.pin;
        }
    },
    { immediate: true }
);

const onFileSelect = (event) => {
    form.profile = event.files[0];
};

function updateAccount() {
    submitting.value = true;
    errors.value = {};

    const formData = new FormData();

    Object.entries(form).forEach(([key, value]) => {
        if (!value) value = '';
        formData.append(key, value);
    });

    formData.append('_method', 'put');

    settingService
        .updateAccountSetting(formData)
        .then((response) => {
            toast.success(response.data.message);
            router.push({ name: 'dashboard' });
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
            form.profile = '';
            form.password = '';
            form.password_confirmation = '';
        });
}
</script>

<template>
    <div class="card border-0 shadow-1">
        <h5>Account Settings</h5>
        <form action="" method="post" @submit.prevent="updateAccount">
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
                    <label for="password">Password </label>
                    <Password v-model="form.password" :invalid="Boolean(errors?.password?.at(0))" :inputProps="{ autocomplete: true, id: 'password' }" />
                    <ValidationErrorMessage :error="errors?.password?.at(0)" />
                </div>

                <!-- Password Confirmation -->
                <div class="field col-12 md:col-6">
                    <label for="password_confirmation">Confirm Password </label>
                    <Password v-model="form.password_confirmation" :invalid="Boolean(errors?.password_confirmation?.at(0))" :inputProps="{ autocomplete: true, id: 'password_confirmation' }" />
                    <ValidationErrorMessage :error="errors?.password_confirmation?.at(0)" />
                </div>

                <!-- Pin -->
                <div class="field col-12" v-if="authStore?.user?.role == 'Customer'">
                    <label for="pin">Pin <small class="p-error">*</small></label>
                    <InputNumber v-model.trim="form.pin" inputId="pin" :useGrouping="false" :invalid="Boolean(errors?.pin?.at(0))" />
                    <ValidationErrorMessage :error="errors?.pin?.at(0)" />
                </div>

                <!-- Profile -->
                <div class="field col-12">
                    <label for="profile">Profile </label>
                    <FileUpload chooseLabel="Upload Profile" inputId="profile" mode="basic" accept="image/*" :maxFileSize="1000000" @select="onFileSelect" class="w-full" />
                    <ValidationErrorMessage :error="errors?.profile?.at(0)" />
                </div>
            </div>

            <div class="flex gap-3 mt-1">
                <RouterLink :to="{ name: 'dashboard' }">
                    <Button label="Cancel" severity="secondary" outlined />
                </RouterLink>
                <Button type="submit" label="Update" :loading="submitting" />
            </div>
        </form>
    </div>
</template>
