import { createRouter, createWebHistory } from 'vue-router'

import NotFound from "./NotFound.vue";
import Home from "./Home.vue";


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
