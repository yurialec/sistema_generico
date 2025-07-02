import './bootstrap';
import './sidebar';
import { createApp, defineAsyncComponent } from 'vue';
import Swal from 'sweetalert2';

const app = createApp({});

app.config.globalProperties.$swal = Swal;

const components = import.meta.glob('./Components/**/*.vue');
for (const [path, definition] of Object.entries(components)) {
    const name = path.split('/').pop().replace(/\.\w+$/, '');
    app.component(name, defineAsyncComponent(definition));
}

app.mount('#app');