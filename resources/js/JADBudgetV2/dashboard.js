import { createApp } from "vue";
import Dashboard from "./Vue/Views/Dashboard.vue";

document.addEventListener('DOMContentLoaded', () => {
    const dashboardApp = createApp(Dashboard);
    dashboardApp.mount('#dashboard');
})