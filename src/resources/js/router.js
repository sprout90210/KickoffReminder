import { createRouter, createWebHistory } from 'vue-router'

import NotFound from "./pages/NotFound.vue";
import Home from "./pages/Home.vue";


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "Home",
            component: Home,
        },

        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: NotFound,
        },
    ]
})

export default router;
