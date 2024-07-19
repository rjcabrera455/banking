import axios from 'axios';

const authService = {
    login(data) {
        return axios.post('auth/login', data);
    }
};

export default authService;
