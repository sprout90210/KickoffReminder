import { createStore } from "vuex";
import auth from "./modules/auth";
import ui from "./modules/ui";

const store = createStore({
	modules: {
		auth,
		ui,
	},
});

export default store;
