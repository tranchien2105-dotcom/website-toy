import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router';
import { createPinia } from 'pinia';
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import { CkeditorPlugin } from '@ckeditor/ckeditor5-vue';

createApp(App)
    .use(router)
    .use(createPinia())
    .use(Vue3Toastify)
    .use(CkeditorPlugin)
    .mount('#app');