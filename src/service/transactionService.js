import axios from 'axios';

const transactionService = {
    getTransactions(params) {
        return axios.get('transactions', { params });
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
};

export default transactionService;
