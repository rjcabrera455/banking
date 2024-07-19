<script setup>
import { ref, reactive } from 'vue';
import AppConfig from '@/layout/AppConfig.vue';
import { useAuthStore } from '@/stores/auth';
import authService from '@/service/authService';
import ValidationErrorMessage from '@/components/ValidationErrorMessage.vue';
import useToast from '@/utils/toast';

const authStore = useAuthStore();
const toast = useToast();
const errors = ref({});
const submitting = ref(false);

const form = reactive({
    email: '',
    password: '',
    remember_me: false
});

function login() {
    submitting.value = true;
    errors.value = {};
    authService
        .login(form)
        .then((response) => {
            authStore.login(response.data.access_token);
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
            form.password = '';
        });
}

// const logoUrl = computed(() => {
//     return `/layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
// });
</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <!-- <img :src="logoUrl" alt="Sakai logo" class="mb-5 w-6rem flex-shrink-0" /> -->
            <div>
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 1rem">
                    <div class="text-center mb-5">
                        <!-- <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" /> -->
                        <div class="text-900 text-3xl font-medium mb-3">Welcome, User</div>
                        <span class="text-600 font-medium">Sign in to continue</span>
                    </div>

                    <!-- Login Form -->
                    <form action="" method="post" @submit.prevent="login">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="block text-900 text-xl font-medium mb-2">Email</label>

                            <InputText id="email" type="text" placeholder="Email address" class="w-full md:w-30rem mb-2" style="padding: 1rem" v-model.trim="form.email" :invalid="Boolean(errors?.email?.at(0))" />

                            <ValidationErrorMessage :error="errors?.email?.at(0)" />
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="block text-900 font-medium text-xl mb-2">Password</label>

                            <Password id="password" v-model="form.password" placeholder="Password" :toggleMask="true" class="w-full mb-2" inputClass="w-full" :inputStyle="{ padding: '1rem' }" :invalid="Boolean(errors?.password?.at(0))"></Password>

                            <ValidationErrorMessage :error="errors?.password?.at(0)" />
                        </div>

                        <div class="flex align-items-center justify-content-between mb-5 gap-5">
                            <div class="flex align-items-center">
                                <Checkbox v-model="form.remember_me" id="remember_me" binary class="mr-2"></Checkbox>
                                <label for="remember_me">Remember me</label>
                            </div>
                            <!-- <a class="font-medium no-underline ml-2 text-right cursor-pointer" style="color: var(--primary-color)">Forgot password?</a> -->
                        </div>

                        <Button type="submit" label="Login" class="w-full p-3 text-xl" :loading="submitting" :disabled="submitting"></Button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
