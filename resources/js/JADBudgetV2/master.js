import { createApp } from "vue";

import Header from "./Vue/Header.vue" ;
import Toast from "./Vue/Toast.vue";

document.addEventListener('DOMContentLoaded', () => {
    const headerApp = createApp(Header);
    headerApp.mount('#header');

    const toastApp = createApp(Toast);
    toastApp.mount('#toastField');
});