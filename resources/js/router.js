import { createRouter, createWebHistory } from 'vue-router';
import Home from './Pages/Home.vue';
import Register from './Pages/Register.vue';
import Edit from './Pages/Edit.vue';
import History from './Pages/History.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/register', component: Register },
    { path: '/edit', component: Edit },
    { path: '/history', component: History },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
