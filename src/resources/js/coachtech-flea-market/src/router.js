import { createRouter, createWebHashHistory } from 'vue-router';
import Item from './components/Item.vue';
import Detail from './components/Detail.vue';
import Header from './components/Header.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Comment from './components/Comment.vue';
import Purchase from './components/Purchase.vue';
import AddressChangeForm from './components/AddressChangeForm.vue';
import My_page from './components/My_page.vue';
import Sell from './components/Sell.vue';
import ProfileEdit from './components/ProfileEdit.vue';

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
    {
        path: "/comment/:id",
        name: "comment",
        component: Comment,
    },
    {
        path: "/purchase/:id",
        name: "purchase",
        component: Purchase,
    },
    {
        path: '/address-change',
        name: 'addressChangeForm',
        component: AddressChangeForm,
    },
    {
        path: '/my_page',
        name: 'my_page',
        component: My_page,
    },
    {
        path: '/sell',
        name: 'sell',
        component: Sell
    },
    {
        path: '/edit-profile',
        name: 'profileEdit',
        component: ProfileEdit
    }
]

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

export default router;

