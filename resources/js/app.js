import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue';
import axios from 'axios';
import store from './store';
import { mask } from 'vue-the-mask';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.baseURL = 'http://localhost:8000/';
axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios = axios;

const app = createApp({});
app.directive('mask', mask);

const components = import.meta.glob('./components/**/*.vue');
Object.entries(components).forEach(([path, importFunction]) => {
    const componentName = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(componentName, defineAsyncComponent(importFunction));
});

app.use(store);
app.mount('#app');
