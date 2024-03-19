import { createRouter, createWebHistory } from "vue-router";
import store from "@/store/index";

import Home from "./pages/Home.vue";
import Team from "./pages/Team.vue";
import Competition from "./pages/Competition.vue";
import Reminders from "./pages/Reminders.vue";
import Favorites from "./pages/Favorites.vue";
import Terms from "./pages/Terms.vue";
import Privacy from "./pages/Privacy.vue";
import Contact from "./pages/Contact.vue";
import NotFound from "./pages/NotFound.vue";
import Registration from "./pages/auth/Registration.vue";
import Login from "./pages/auth/Login.vue";
import ForgotPassword from "./pages/auth/ForgotPassword.vue";
import ResetPassword from "./pages/auth/ResetPassword.vue";
import EditUser from "./pages/auth/EditUser.vue";
import EditPassword from "./pages/auth/EditPassword.vue";
import DeleteUser from "./pages/auth/DeleteUser.vue";
import EmailVerificationRequest from "./pages/auth/EmailVerificationRequest.vue";
import EmailVerificationSent from "./pages/auth/EmailVerificationSent.vue";

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
			name: "Competition",
			component: Competition,
		},
		{
			path: "/teams/:teamId",
			name: "Team",
			component: Team,
		},
		{
			path: "/email/verification/request",
			name: "EmailVerificationRequest",
			component: EmailVerificationRequest,
		},
		{
			path: "/email/verification/sent",
			name: "EmailVerificationSent",
			component: EmailVerificationSent,
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
			path: "/Contact",
			name: "Contact",
			component: Contact,
		},
		{
			path: "/:pathMatch(.*)*",
			name: "NotFound",
			component: NotFound,
		},
	],

	scrollBehavior(to, from, savedPosition) {
		return savedPosition ? savedPosition : { top: 0 };
	},
});

router.beforeEach((to, from, next) => {
	const isLoggedIn = store.state.auth.isLoggedIn;
	const isLineUser = store.state.auth.isLineUser;
	const authRequiredPages = [
		"EditUser",
		"DeleteUser",
		"EditPassword",
		"Favorites",
		"Reminders",
	];
	const noAuthPages = [
		"Login",
		"Registration",
		"ForgotPassword",
		"EmailVerificationRequest",
		"EmailVerificationSent"
	];
	const authRequired = authRequiredPages.includes(to.name);
	const noAuthRequired = noAuthPages.includes(to.name);

	if (authRequired && !isLoggedIn) {
		next({ path: "/" });
	} else if (noAuthRequired && isLoggedIn) {
		next({ path: "/" });
	} else if ((to.name === "EditUser" || to.name === "EditPassword") && isLineUser) {
		next({ path: "/" });
	} else {
		next();
	}
});

export default router;
