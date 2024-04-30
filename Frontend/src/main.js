import { createApp } from 'vue';
import App from './App.vue';
import './index.css';
import router from './router';
import axios from 'axios';
import 'font-awesome/css/font-awesome.css';

import { createPinia } from 'pinia'
const pinia = createPinia();

const app = createApp(App);
app.config.globalProperties.$http = axios;

app.use(router)
app.use(pinia)
.mount('#app');
