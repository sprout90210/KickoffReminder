import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import store from "./store";
import App from "./App.vue";
import "../css/app.css";

async function init() {
	await store.dispatch("checkAuth");
	createApp(App).use(router).use(store).mount("#app");
}

init();
