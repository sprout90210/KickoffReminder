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
		logout(state) {
			state.isLoggedIn = false;
			state.isLineUser = false;
		},
		setLineUser(state, status) {
			state.isLineUser = status;
		},
		toggleReceiveReminder(state) {
			state.receiveReminder = !state.receiveReminder;
		},
		setReceiveReminder(state, status) {
			state.receiveReminder = Boolean(status);
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
			commit("setReceiveReminder", receiveReminder);
		},

		async checkAuth({ dispatch }) {
			await axios
				.get("/api/check")
				.then((res) => {
					dispatch("userStatusUpdate", {
						isLoggedIn: res.data.isLoggedIn,
						isLineUser: res.data.isLineUser,
						remindTime: res.data.remindTime,
						receiveReminder: res.data.receiveReminder,
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

		handleError({ commit, dispatch }, { error }) {
			const defaultMessage = "エラーが発生しました。後でもう一度お試しください。";
			let errorMessage = defaultMessage;

			if (error.response && error.response.status) {
				switch (e.response.status) {
					case 401: //入力情報エラー
						errorMessage = error.response.data?.error ?? "ログインしてください。";
						commit("logout");
						break;
					case 419: //token切れ
						errorMessage = "セッション切れのため、ページをリロードします。";
						setTimeout(() => location.reload(), 1000); // 1秒後にリロード
						break;
					case 422: //バリデーション
						errorMessage = error.response.data?.message ?? "入力情報に誤りがあります。";
						break;
					default:
						errorMessage = error.response.data?.error ?? defaultMessage;
				}
			}

			dispatch("triggerPopup", { message: errorMessage, color: "red" });
		},
	},
};
