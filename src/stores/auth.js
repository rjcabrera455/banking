import { defineStore } from 'pinia';
import { useRouter } from 'vue-router';
import { useStorage } from '@vueuse/core';
import { computed, ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter();
    const accessToken = useStorage('access_token', '');

    const checkToken = computed(() => !!accessToken.value);
    const user = ref({});

    function setAccessToken(value) {
        accessToken.value = value;
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken.value}`;
    }

    function login(accessToken) {
        setAccessToken(accessToken);
        router.push({ name: 'dashboard' });
    }

    function destroyTokenAndRedirectTo(routeName = 'auth.login') {
        setAccessToken(null);
        router.push({ name: routeName });
    }

    function logout() {
        window.axios
            .post('auth/logout')
            .then((response) => {
                user.value = {};
            })
            .finally(() => {
                destroyTokenAndRedirectTo();
            });
    }

    return {
        login,
        logout,
        checkToken,
        destroyTokenAndRedirectTo,
        user
    };
});
