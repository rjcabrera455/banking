import axios from 'axios';

const dashboardService = {
    getAdminDashboard(params) {
        return axios.get('dashboard.admin', { params });
    },
    getCustomerDashboard(params) {
        return axios.get('dashboard.customer', { params });
    }
};

export default dashboardService;
