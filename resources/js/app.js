/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.baseURL = 'http://localhost:8000/';
window.axios = axios;

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
import SidebarComponent from './components/Admin/Theme/SidebarComponent.vue';
import HeaderComponent from './components/Admin/Theme/HeaderComponent.vue';
import AlerComponent from './components/Admin/Theme/AlerComponent.vue';

//USERS
import UsersIndexComponent from './components/Admin/Users/UsersIndexComponent.vue';
import UsersMeComponent from './components/Admin/Users/UsersMeComponent.vue';
import UsersCreateComponent from './components/Admin/Users/UsersCreateComponent.vue';
app.component('users-index-component', UsersIndexComponent);
app.component('users-me-component', UsersMeComponent);
app.component('users-create-component', UsersCreateComponent);

//ROLES
import RolesIndexComponent from './components/Admin/Roles/RolesIndexComponent.vue';
import RolesCreateComponent from './components/Admin/Roles/RolesCreateComponent.vue';
import RolesEditComponent from './components/Admin/Roles/RolesEditComponent.vue';
app.component('roles-index-component', RolesIndexComponent);
app.component('roles-create-component', RolesCreateComponent);
app.component('roles-edit-component', RolesEditComponent);

//Dashboard
app.component('example-component', ExampleComponent);
app.component('sidebar-component', SidebarComponent);
app.component('header-component', HeaderComponent);
app.component('alert-component', AlerComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
