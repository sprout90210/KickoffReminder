import { createRouter, createWebHistory } from 'vue-router'

import Home from "./pages/Home.vue";
import Terms from "./pages/Terms.vue";
import Privacy from "./pages/Privacy.vue";
import Inquiry from "./pages/Inquiry.vue";
import TeamDetail from "./pages/TeamDetail.vue";
import CompetitionDetail from "./pages/CompetitionDetail.vue";
import NotFound from "./pages/NotFound.vue";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home,
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
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        }
        if (to.name === 'Terms') {
            return { top: 0 }
        }
        return false;
    }
    
})

export default router;
