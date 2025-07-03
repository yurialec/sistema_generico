import './bootstrap';
import './sidebar';
import FloatingAlertPlugin from './plugins/floatingAlert';
import ConfirmPlugin from './plugins/confirm';

import { createApp, defineAsyncComponent } from 'vue';

const app = createApp({});

const components = import.meta.glob('./Components/**/*.vue');
for (const [path, definition] of Object.entries(components)) {
    const name = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(name, defineAsyncComponent(definition));
}

app.use(FloatingAlertPlugin);
app.use(ConfirmPlugin);

app.mount('#app');
