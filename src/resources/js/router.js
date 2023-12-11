import { createRouter, createWebHistory } from "vue-router"
import store from "@/store/index";

import Home from "./pages/home/Home.vue";
import Terms from "./pages/Terms.vue";
import Privacy from "./pages/Privacy.vue";
import Inquiry from "./pages/Inquiry.vue";
import TeamDetail from "./pages/team/TeamDetail.vue";
import CompetitionDetail from "./pages/competition/CompetitionDetail.vue";
import NotFound from "./pages/NotFound.vue";
import Reminders from "./pages/reminders/Reminders.vue";
import Favorites from "./pages/favorites/Favorites.vue";
import MyPage from "./pages/auth/MyPage.vue";
import Registration from "./pages/auth/registration.vue";
import Login from "./pages/auth/Login.vue";
import ForgotPassword from "./pages/auth/ForgotPassword.vue";
import ResetPassword from "./pages/auth/ResetPassword.vue";
import EditUser from "./pages/auth/EditUser.vue";
import EditPassword from "./pages/auth/EditPassword.vue";
import DeleteUser from "./pages/auth/DeleteUser.vue";



const router = createRouter({
	history: createWebHistory(),
	routes: [
		{
			path: "/",
			name: "Home",
			component: Home,
		},
		{
			path: "/competitions/:competitionId",
			name: "CompetitonDetail",
			component: CompetitionDetail,
		},
		{
			path: "/teams/:teamId",
			name: "TeamDetail",
			component: TeamDetail,
		},
		{
			path: "/registration",
			name: "Registration",
			component: Registration,
		},
		{
			path: "/login",
			name: "Login",
			component: Login,
		},
		{
			path: "/mypage",
			name: "MyPage",
			component: MyPage,
		},
		{
			path: "/reminders",
			name: "Reminders",
			component: Reminders,
		},
		{
			path: "/favorites",
			name: "Favorites",
			component: Favorites,
		},
		{
			path: "/password/forgot",
			name: "ForgotPassword",
			component: ForgotPassword,
		},
		{
			path: "/password/reset",
			name: "ResetPassword",
			component: ResetPassword,
		},
		{
			path: "/password/edit",
			name: "EditPassword",
			component: EditPassword,
		},
		{
			path: "/user/edit",
			name: "EditUser",
			component: EditUser,
		},
		{
			path: "/user/delete",
			name: "DeleteUser",
			component: DeleteUser,
		},
		{
			path: "/terms",
			name: "Terms",
			component: Terms,
		},
		{
			path: "/privacy",
			name: "Privacy",
			component: Privacy,
		},
		{
			path: "/inquiry",
			name: "Inquiry",
			component: Inquiry,
		},
		{
			path: "/:pathMatch(.*)*",
			name: "NotFound",
			component: NotFound,
		},
	],

	scrollBehavior(to, from, savedPosition) {
		return savedPosition ? savedPosition : { top: 0 }
	},
});


router.beforeEach((to, from, next) => {
	const isLoggedIn = store.state.isLoggedIn;
	const isLineUser = store.state.isLineUser;
	const authRequiredPages = ["MyPage", "EditUser", "DeleteUser", "EditPassword", "Favorites"];
	const noAuthPages = ["Login", "Registration", "ForgotPassword"];
	const authRequired = authRequiredPages.includes(to.name);
	const noAuthRequired = noAuthPages.includes(to.name);

	if (authRequired && !isLoggedIn) {
		next({ path: "/login" });
	} else if (noAuthRequired && isLoggedIn) {
		next({ path: "/" });
	} else if ((to.name === "EditUser" || to.name === "EditPassword") && isLineUser) {
		next({ path: "/" });
	} else {
		next();
	}

});

export default router;
