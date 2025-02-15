import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
    // scrollBehavior(to, from, savedPosition) {
    //     if (to.hash) {
    //         return {
    //             selector: to.hash,
    //             behavior: 'smooth',
    //         }
    //     }
    // }
})

export default router