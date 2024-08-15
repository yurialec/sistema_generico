import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import store from './store';

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
import UsersEditComponent from './components/Admin/Users/UsersEditComponent.vue';
import UsersProfileComponent from './components/Admin/Users/UsersProfileComponent.vue';

//Role
import RolesIndexComponent from './components/Admin/Roles/RolesIndexComponent.vue';
import RolesCreateComponent from './components/Admin/Roles/RolesCreateComponent.vue';
import RolesEditComponent from './components/Admin/Roles/RolesEditComponent.vue';

//Permissions
import PermissionsIndexComponent from './components/Admin/Permissions/PermissionsIndexComponent.vue';
import PermissionsCreateComponent from './components/Admin/Permissions/PermissionsCreateComponent.vue';
import PermissionsEditComponent from './components/Admin/Permissions/PermissionsEditComponent.vue';

//Menus
import MenusIndexComponent from './components/Admin/Menus/MenusIndexComponent.vue';
import MenusEditComponent from './components/Admin/Menus/MenusEditComponent.vue';
import MenusCreateComponent from './components/Admin/Menus/MenusCreateComponent.vue';


//SITE
//LOGO
import SiteLogoIndexComponent from './components/Site/Logo/SiteLogoIndexComponent.vue';
import SiteLogoCreateComponent from './components/Site/Logo/SiteLogoCreateComponent.vue';
import SiteLogoEditComponent from './components/Site/Logo/SiteLogoEditComponent.vue';

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
app.component('users-edit-component', UsersEditComponent);

//ROLES
app.component('roles-index-component', RolesIndexComponent);
app.component('roles-create-component', RolesCreateComponent);
app.component('roles-edit-component', RolesEditComponent);

//PERMISSION
app.component('permissions-index-component', PermissionsIndexComponent);
app.component('permissions-create-component', PermissionsCreateComponent);
app.component('permissions-edit-component', PermissionsEditComponent);

//MENUS
app.component('menus-index-component', MenusIndexComponent);
app.component('menus-edit-component', MenusEditComponent);
app.component('menus-create-component', MenusCreateComponent);


//SITE
//LOGOTIPO
app.component('site-logo-index-component', SiteLogoIndexComponent);
app.component('site-logo-create-component', SiteLogoCreateComponent);
app.component('site-logo-edit-component', SiteLogoEditComponent);

app.use(store);
app.mount('#app');
