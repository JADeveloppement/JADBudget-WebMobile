import { createApp } from 'vue';
import Login from './Vue/Views/Login.vue';

console.log('JADBudgetV2/index.js');

document.addEventListener('DOMContentLoaded', () => {
    const loginContainerApp = createApp(Login);
    loginContainerApp.mount('#loginContainer');
});