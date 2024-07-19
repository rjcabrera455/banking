import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
window.axios.defaults.baseURL = `${import.meta.env.VITE_API_BASE_URL}/api`;

window.axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            const auth = useAuthStore();
            auth.destroyTokenAndRedirectTo();
        }

        return Promise.reject(error);
    }
);

if (localStorage.getItem('access_token')) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
}
