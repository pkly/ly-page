import { createApp } from 'vue'
import { createPinia } from 'pinia'
import VueSafeTeleport from 'vue-safe-teleport';
import piniaPluginPersistedState from 'pinia-plugin-persistedstate';

import App from './App.vue'

const app = createApp(App)
const pinia = createPinia();

pinia.use(piniaPluginPersistedState);
app.use(pinia);
app.use(VueSafeTeleport);

app.mount('#app');
