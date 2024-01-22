export default {
	state: () => ({
		isLoggedIn: false,
		isLineUser: false,
		remindTime: null,
		receiveReminder: false,
	}),
	mutations: {
		setLoggedIn(state, status) {
			state.isLoggedIn = status;
		},
		setLineUser(state, status) {
			state.isLineUser = status;
		},
		toggleReceiveReminder(state) {
			state.receiveReminder = !state.receiveReminder;
		},
		setReceiveReminder(state, status) {
			state.receiveReminder = status;
		},
		setRemindTime(state, value) {
			state.remindTime = value;
		},
	},
	actions: {
		userStatusUpdate(
			{ commit },
			{ isLoggedIn, isLineUser, remindTime, receiveReminder },
		) {
			commit("setLoggedIn", isLoggedIn);
			commit("setLineUser", isLineUser);
			commit("setRemindTime", remindTime);
			commit("setReceiveReminder", Boolean(receiveReminder));
		},

		async checkAuth({ dispatch }) {
			await axios
				.get("/api/check")
				.then((res) => {
					dispatch("userStatusUpdate", {
						isLoggedIn: res.data.isLoggedIn,
						isLineUser: res.data.isLineUser,
						remindTime: res.data.remindTime,
						receiveReminder: Boolean(res.data.receiveReminder),
					});
				})
				.catch((e) => {
					dispatch("triggerPopup", {
						message:
							"認証状態の確認中にエラーが発生しました。ページをリロードしてください。",
						color: "red",
					});
				});
		},
	},
};
