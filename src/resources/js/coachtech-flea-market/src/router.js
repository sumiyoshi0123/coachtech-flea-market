import { createRouter, createWebHashHistory } from 'vue-router';
import Item from './components/Item.vue';
import Header from './components/Header.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const routes = [
    {
        path: "/",
        name: "item",
        component: Item,
    },
    {
        path: "/header",
        name: "header",
        component: Header,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/login",
        name: "login",
        component: Login,
    },
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

export default router;

