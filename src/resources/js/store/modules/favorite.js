export default {
	state: () => ({
	}),
	mutations: {
	},
	actions: {
		handleFavoriteError({ commit, dispatch }, { error, isFavorite }) {
			const defaultMessage = "エラーが発生しました。後でもう一度お試しください。";
			let errorMessage = defaultMessage;
			let color = "red";

			if (error.response && error.response.status) {
				switch (error.response.status) {
					case 401: //未認証
						errorMessage = "ログインしてください。";
						commit("logout");
						break;
					case 419: //token切れ
						errorMessage = "セッション切れのため、ページをリロードします。";
						setTimeout(() => location.reload(), 1000); // 1秒後にリロード
						break;
					case 409: //登録済み
						isFavorite.value = true;
						errorMessage = error.response.data?.error ?? defaultMessage;
						color = "blue";
						break;
					case 429: //試行回数過多
						break;
					default:
						errorMessage = error.response.data?.error ?? defaultMessage;
				}
			}

			dispatch("triggerPopup", { message: errorMessage, color: color });
		},
	},
};
