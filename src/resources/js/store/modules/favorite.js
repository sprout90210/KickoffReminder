export default {
	state: () => ({
	}),
	mutations: {
	},
	actions: {
		handleFavoriteError({ commit, dispatch }, { error, isFavorite }) {
			let errorMessage = "エラーが発生しました。後でもう一度お試しください。";
			let color = "red";
			switch (error.response.status) {
				case 401:
				case 419:
					commit("setLoggedIn", false);
					errorMessage = "ログインが必要です。";
					break;
				case 409:
					isFavorite.value = true;
					errorMessage =
						error.response.data?.error ??
							"エラーが発生しました。後でもう一度お試しください。";
						color = "blue";
					break;
				case 429:
					break;
				default:
					errorMessage =
						error.response.data?.error ??
							"エラーが発生しました。後でもう一度お試しください。";
			}
			dispatch("triggerPopup", { message: errorMessage, color: color });
		},
	},
};
