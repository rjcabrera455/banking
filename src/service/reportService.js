import axios from 'axios';

const reportService = {
    getTransactions(params) {
        return axios.get('reports/transaction', { params });
    }
};

export default reportService;
