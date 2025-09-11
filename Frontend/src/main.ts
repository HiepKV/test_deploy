import { createApp } from 'vue'
import i18n from '@/plugins/i18n';
import 'bootstrap-icons/font/bootstrap-icons.css'
import './style.css'
import App from './App.vue'
import router from './router';
import { createPinia } from 'pinia';
import store from './store';
const app = createApp(App);
app.use(i18n);
app.use(createPinia());
app.use(store);
app.use(router);
app.mount('#app');

console.log = console.debug = console.info = function () {};
