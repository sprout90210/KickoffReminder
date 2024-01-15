import store from "../store/index.js";

const handleError = (e) => {
	let message = "エラーが発生しました。";
	let color = "red";
	if (e.response.status) {
		switch (e.response.status) {
			case 401:
			case 419:
			case 403:
				message = "ログインしてください。";
				store.commit("setLoggedIn", false);
				break;
			default:
				message =
					e.response.data?.message ??
					"エラーが発生しました。後でもう一度お試しください。";
		}
	}
	store.dispatch("triggerPopup", { message: message, color: color });
};

export default handleError;
