import axios from 'axios';

// User相關的 api
const pwa = axios.create({
  baseURL: 'https://192.168.1.103/toolSystem/'
});


// User 相關的 api
export const apiUserLogin = data => pwa.post('/php/login', data);
export const findMyTools = data => pwa.post('/pwa_php/findMyTools', data);
export const returnSubmit = data => pwa.post('/pwa_php/returnSubmit', data);
export const locate = data => pwa.post('/pwa_php/locate', data);
export const borrowSubmit = data => pwa.post('/pwa_php/borrowSubmit', data);
export const getAllTools = data => pwa.get('/pwa_php/getAllTools',data);
export const history = data => pwa.post('/pwa_php/history',data);
export const getUser = data => pwa.post('/pwa_php/getUser',data);
export const report = data => pwa.post('/pwa_php/report',data);



