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
axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios = axios;

const app = createApp({});

//Theme
import ExampleComponent from './components/ExampleComponent.vue';
import HomeHomeComponent from './components/Admin/Theme/HomeComponent.vue';
import SidebarComponent from './components/Admin/Theme/SidebarComponent.vue';
import HeaderComponent from './components/Admin/Theme/HeaderComponent.vue';
import AlerComponent from './components/Admin/Theme/AlerComponent.vue';

//User
import UsersIndexComponent from './components/Admin/Users/UsersIndexComponent.vue';
import UsersCreateComponent from './components/Admin/Users/UsersCreateComponent.vue';
import UsersProfileComponent from './components/Admin/Users/UsersProfileComponent.vue';

//Role
import RolesIndexComponent from './components/Admin/Roles/RolesIndexComponent.vue';
import RolesCreateComponent from './components/Admin/Roles/RolesCreateComponent.vue';
import RolesEditComponent from './components/Admin/Roles/RolesEditComponent.vue';

//Theme
app.component('example-component', ExampleComponent);
app.component('home-component', HomeHomeComponent);
app.component('sidebar-component', SidebarComponent);
app.component('header-component', HeaderComponent);
app.component('alert-component', AlerComponent);

//USERS
app.component('users-index-component', UsersIndexComponent);
app.component('users-create-component', UsersCreateComponent);
app.component('users-profile-component', UsersProfileComponent);

//ROLES
app.component('roles-index-component', RolesIndexComponent);
app.component('roles-create-component', RolesCreateComponent);
app.component('roles-edit-component', RolesEditComponent);

app.mount('#app');
