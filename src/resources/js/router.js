import { createRouter, createWebHistory } from "vue-router"
import store from "@/store/index";

import Home from "./pages/Home.vue";
import Terms from "./pages/Terms.vue";
import Privacy from "./pages/Privacy.vue";
import Inquiry from "./pages/Inquiry.vue";
import TeamDetail from "./pages/TeamDetail.vue";
import CompetitionDetail from "./pages/CompetitionDetail.vue";
import NotFound from "./pages/NotFound.vue";
import Registration from "./pages/auth/registration.vue";
import Login from "./pages/auth/Login.vue";
import ForgotPassword from "./pages/auth/ForgotPassword.vue";
import ResetPassword from "./pages/auth/ResetPassword.vue";
import MyPage from "./pages/auth/MyPage.vue";
import EditEmail from "./pages/auth/EditEmail.vue";
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
			path: "/teams/:teamId",
			name: "TeamDetail",
			component: TeamDetail,
		},
		{
			path: "/competitions/:competitionId",
			name: "CompetitonDetail",
			component: CompetitionDetail,
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

		{
			path: "/mypage",
			name: "MyPage",
			component: MyPage,
		},
		{
			path: "/email/edit",
			name: "EditEmail",
			component: EditEmail,
		},
		{
			path: "/password/edit",
			name: "EditPassword",
			component: EditPassword,
		},
		{
			path: "/user/delete",
			name: "DeleteUser",
			component: DeleteUser,
		},
	],

	scrollBehavior(to, from, savedPosition) {
		return savedPosition ? savedPosition : { top: 0 }
	},
});

// router.beforeEach((to, from, next) => {

// 	const isLoggedIn = store.state.isLoggedIn;
// 	const authRequiredPages = [ "MyPage", "EditEmail", "EditPassword", "DeleteUser"];
// 	const authRequired = authRequiredPages.includes(to.name);

	// if (authRequired && !isLoggedIn){
	// 	next({ name: "Login" });
	// } else {
	// 	next();
	// }
// });

export default router;
