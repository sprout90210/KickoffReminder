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

		handleError({ commit, dispatch }, { error }) {
			let errorMessage = "エラーが発生しました。後でもう一度お試しください。";
			let color = "red";
			if (error.response.status) {
				switch (error.response.status) {
					case 401:
					case 419:
					case 403:
						errorMessage = "ログインしてください。";
						commit("setLoggedIn", false);
						break;
					default:
						errorMessage =
							error.response.data?.error ??
							"エラーが発生しました。後でもう一度お試しください。";
				}
			}
			dispatch("triggerPopup", { message: errorMessage, color: color });
		},
	},
};
