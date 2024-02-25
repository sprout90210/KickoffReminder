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
					commit("logout");
					errorMessage = "ログインが必要です。";
					break;
				case 409: //すでに登録済みの場合
					isFavorite.value = true;
					errorMessage =
						error.response.data?.error ??
							"エラーが発生しました。後でもう一度お試しください。";
					color = "blue";
					break;
				case 429: //試行回数が過多の場合
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
