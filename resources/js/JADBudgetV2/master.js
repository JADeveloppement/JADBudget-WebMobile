import { createApp } from "vue";

import Header from "./Vue/Layouts/Header.vue" ;
import Toast from "./Vue/Components/UI/Toast.vue";

document.addEventListener('DOMContentLoaded', () => {
    const headerApp = createApp(Header);
    headerApp.mount('#header');

    const toastApp = createApp(Toast);
    toastApp.mount('#toastField');
});