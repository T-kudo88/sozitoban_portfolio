import { createRouter, createWebHistory } from 'vue-router';
import Home from './Pages/Home.vue';
import Register from './Pages/Register.vue';
import Edit from './Pages/Edit.vue';
import History from './Pages/History.vue';
import TaskHistory from "./pages/TaskHistory.vue";
import TaskList from "./pages/Index.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/register', component: Register },
    { path: '/edit', component: Edit },
    { path: '/history', component: History },
    { path: "/", component: TaskList },
    { path: "/task-histories", component: TaskHistory }, // ✅ 履歴ページを追加
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
