import { createRouter, createWebHistory } from 'vue-router';
import HomeView from './views/HomeView.vue';
import SignupView from './views/SignupView.vue';
import TenantLoginView from './views/TenantLoginView.vue';

const history = createWebHistory(import.meta.env.BASE_URL ?? '/');

const router = createRouter({
    history,
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView,
        },
        {
            path: '/signup',
            name: 'signup',
            component: SignupView,
        },
        {
            path: '/aktonz/login',
            name: 'aktonz-login',
            component: TenantLoginView,
        },
    ],
    scrollBehavior() {
        return { top: 0 };
    },
});

export default router;
