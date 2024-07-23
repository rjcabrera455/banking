import axios from 'axios';

const dashboardService = {
    getAdminDashboard(params) {
        return axios.get('dashboard.admin', { params });
    }
};

export default dashboardService;
