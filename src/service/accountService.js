import axios from 'axios';

const accountService = {
    getAccounts(params) {
        return axios.get('accounts', { params });
    },
    getAccount(id, params) {
        return axios.get('accounts/' + id, { params });
    },
    addAccount(data) {
        return axios.post('accounts', data);
    },
    updateAccount(data, id) {
        return axios.put('accounts/' + id, data);
    },
    deleteAccount(id) {
        return axios.delete('accounts/' + id);
    }
};

export default accountService;
