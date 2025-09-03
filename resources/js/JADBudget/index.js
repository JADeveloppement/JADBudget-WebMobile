import { createApp } from 'vue';
import Login from './Vue/Views/Login.vue';

document.addEventListener('DOMContentLoaded', () => {
    const loginContainerApp = createApp(Login);
    loginContainerApp.mount('#loginContainer');
});