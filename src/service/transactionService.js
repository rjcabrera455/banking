import axios from 'axios';

const transactionService = {
    getAccount(params) {
        return axios.get('auth/account', { params });
    },
    deposit(data) {
        return axios.put('transactions/deposit', data);
    }
    // updateAccount(data, id) {
    //     return axios.put('accounts/' + id, data);
    // },
    // deleteAccount(id) {
    //     return axios.delete('accounts/' + id);
    // }
};

export default transactionService;
