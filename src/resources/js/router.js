import { createRouter, createWebHistory } from 'vue-router'

import Home from "./pages/Home.vue";
import Terms from "./pages/Terms.vue";
import Privacy from "./pages/privacy.vue";
import Inquiry from "./pages/inquiry.vue";
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
    ]
})

export default router;
