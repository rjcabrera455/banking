import axios from 'axios';

const settingService = {
    updateAccountSetting(data) {
        return axios.post('settings/account', data);
    }
};

export default settingService;
