import store from "../store/index.js";

const handleAuthError = (e) => {
	let message = "エラーが発生しました。後でもう一度お試しください。";
	let color = "red";
	if (e.response.status) {
		switch (e.response.status) {
			case 419:
				message = "ログインしてください。";
				store.commit("setLoggedIn", false);
				break;
			default:
				message = e.response.data?.message;
		}
	}
	store.dispatch("triggerPopup", { message: message, color: color });
};

export default handleAuthError;
