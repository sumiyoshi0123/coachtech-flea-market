import { createRouter, createWebHashHistory } from 'vue-router';
import Item from './components/Item.vue';
import Detail from './components/Detail.vue';
import Header from './components/Header.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const routes = [
    {
        path: "/item",
        name: "item",
        component: Item,
    },
    {
        path: "/item/:id",
        name: "detail",
        component: Detail,
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

