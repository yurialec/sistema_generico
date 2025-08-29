import './bootstrap';
import FloatingAlertPlugin from './plugins/floatingAlert';
import ConfirmPlugin from './plugins/confirm';
import LoadingOverlayPlugin from './plugins/loadingOverlay';
import VueTheMask from 'vue-the-mask';

import { createApp, defineAsyncComponent } from 'vue';

const app = createApp({});

const components = import.meta.glob('./Components/**/*.vue');
for (const [path, definition] of Object.entries(components)) {
    const name = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(name, defineAsyncComponent(definition));
}

app.use(FloatingAlertPlugin);
app.use(ConfirmPlugin);
app.use(LoadingOverlayPlugin);
app.use(VueTheMask);

app.mount('#app');
