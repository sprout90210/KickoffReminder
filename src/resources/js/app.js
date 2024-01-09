import "./bootstrap";
import { createApp } from "vue";
import router from "./router";
import store from "./store";
import App from "./App.vue";
import "../css/app.css";

async function checkAuth() {
	try {
		const res = await axios.get("/api/check");
		store.commit("setLoggedIn", res.data.isLoggedIn);
		store.commit("setLineUser", res.data.isLineUser);
	} catch (e) {
		console.error("認証状態の確認中にエラーが発生しました", e);
		store.dispatch("triggerPopup", { message: "認証状態の確認中にエラーが発生しました。ページをリロードしてください。", color: "red" });
	}
}

async function init() {
	await checkAuth();
	createApp(App).use(router).use(store).mount("#app");
}

init();
