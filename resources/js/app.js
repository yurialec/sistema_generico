import './bootstrap';
import './sidebar';

import { createApp, defineAsyncComponent } from 'vue';
import FloatingAlert from './Components/FloatingAlert.vue';

const app = createApp({});

const components = import.meta.glob('./Components/**/*.vue');
for (const [path, definition] of Object.entries(components)) {
    const name = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(name, defineAsyncComponent(definition));
}

app.mount('#app');

const alertApp = createApp(FloatingAlert);
const alertInstance = alertApp.mount(document.createElement('div'));
document.body.appendChild(alertInstance.$el);

window.alertSuccess = (msg) => {
    alertInstance.show(msg, 'success');
};
window.alertDanger = (msg) => {
    alertInstance.show(msg, 'danger');
};
