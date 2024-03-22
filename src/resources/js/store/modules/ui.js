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
	},
};
