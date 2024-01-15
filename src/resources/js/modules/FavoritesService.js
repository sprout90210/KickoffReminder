import store from "../store/index.js";

const favoritesService = {
	toggleFavorite(teamId, isSubmitting, isFavorite) {
		isSubmitting.value = true;
		const action = isFavorite.value ? "delete" : "post";
		const endpoint = isFavorite.value
			? `/api/favorites/${teamId}`
			: "/api/favorites";
		const message = isFavorite.value
			? "お気に入り登録解除しました。"
			: "お気に入りに登録しました。";

		axios[action](endpoint, { team_id: teamId })
			.then(() => {
				isFavorite.value = !isFavorite.value;
				store.dispatch("triggerPopup", { message });
			})
			.catch((e) => {
				this.handleError(e, isFavorite);
			})
			.finally(() => {
				isSubmitting.value = false;
			});
	},

	deleteFavorite(teamId, emit) {
		axios
			.delete(`/api/favorites/${teamId}`)
			.then(() => {
				emit("deleteFavorite", teamId);
				store.dispatch("triggerPopup", {
					message: "お気に入り登録解除しました。",
				});
			})
			.catch((e) => this.handleError(e, null));
	},

	handleError(e, isFavorite) {
		let errorMessage = "エラーが発生しました。後でもう一度お試しください。";
		let color = "red";
		switch (e.response.status) {
			case 401:
			case 419:
				store.commit("setLoggedIn", false);
				errorMessage = "ログインが必要です。";
				break;
			case 409:
				isFavorite.value = true;
				errorMessage = e.response?.data?.message;
				color = "blue";
				break;
			case 429:
				break;
			default:
				errorMessage = e.response?.data?.message;
		}

		store.dispatch("triggerPopup", { message: errorMessage, color: color });
	},
};

export default favoritesService;
