import { createStore } from "vuex";
import auth from "./modules/auth";
import ui from "./modules/ui";
import favorite from "./modules/favorite";

const store = createStore({
	modules: {
		auth,
		ui,
		favorite,
	},
});

export default store;
