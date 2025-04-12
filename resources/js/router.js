import { createRouter, createWebHistory } from 'vue-router'
import Home from './Pages/Home.vue'
import Register from './Pages/Register.vue'
import History from './Pages/History.vue'
import EditUser from './Pages/EditUser.vue'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/register', name: 'register', component: Register },
    { path: '/history', name: 'history', component: History },
    { path: '/users/edit', name: 'editUser', component: EditUser },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
