export default {
	state: () => ({
		isMenuOpen: false,
		activeTab: "standings",
		showPopup: false,
		popupMessage: "",
		popupColor: "green",
	}),

	mutations: {
		toggleMenu(state) {
			state.isMenuOpen = !state.isMenuOpen;
		},
		setActiveTab(state, tabName) {
			state.activeTab = tabName;
		},
		setPopupMessage(state, { message, color }) {
			state.popupMessage = message;
			state.popupColor = color;
			state.showPopup = true;
		},
		hidePopup(state) {
			state.showPopup = false;
		},
	},

	actions: {
		triggerPopup({ commit }, { message, color }) {
			commit("setPopupMessage", { message, color });
			setTimeout(() => {
				commit("hidePopup");
			}, 2500);
		},

		changeActiveTab({ commit }, tabName) {
			commit("setActiveTab", tabName);
		},

		handleError({ commit, dispatch }, { error, router }) {
			let errorMessage = "エラーが発生しました。後でもう一度お試しください。";
			if (error.response && error.response.status) {
				switch (error.response.status) {
					case 401:
					case 419:
						errorMessage = "ログインしてください。";
						dispatch("triggerPopup", { message: errorMessage, color: "red" });
						commit("logout");
						router.push("/login");
						break;
					case 422: //バリデーションエラー
						errorMessage = 
							error.response.data?.message ??
							"入力情報に誤りがあります。";
						dispatch("triggerPopup", { message: errorMessage, color: "red" });
						break;
					default:
						errorMessage =
							error.response.data?.error ??
							"エラーが発生しました。後でもう一度お試しください。";
						dispatch("triggerPopup", { message: errorMessage, color: "red" });
				}
			}
		},
	},
};
