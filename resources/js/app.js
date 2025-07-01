import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue';

const app = createApp({});

const components = import.meta.glob('./Components/**/*.vue');
for (const [path, definition] of Object.entries(components)) {
    const name = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(name, defineAsyncComponent(definition));
}

app.mount('#app');