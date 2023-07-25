import './bootstrap';
import { createApp } from 'vue'
import router from './router';
import store from './store'
import App from './App.vue'
import '../css/app.css';

const app = createApp(App)

app.use(router)
app.use(store)
app.mount('#app')
