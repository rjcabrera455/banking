import axios from 'axios';

const transactionService = {
    getAccount(params) {
        return axios.get('auth/account', { params });
    },
    getReceiverDetails(params) {
        return axios.get('transactions/receiver', { params });
    },
    deposit(data) {
        return axios.put('transactions/deposit', data);
    },
    withdraw(data) {
        return axios.put('transactions/withdraw', data);
    },
    transfer(data) {
        return axios.put('transactions/transfer', data);
    }
    // updateAccount(data, id) {
    //     return axios.put('accounts/' + id, data);
    // },
    // deleteAccount(id) {
    //     return axios.delete('accounts/' + id);
    // }
};

export default transactionService;
