<script setup>
import { ref, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

// SVGファイルをimportを使用してインポート
import logo from '../assets/logo.svg';

// ユーザーがログインしているかどうかを確認
const isLoggedIn = computed(() => {
    return !!localStorage.getItem('token');
});

//ログイン画面へ
const login = () => {
    router.push({ name: "login" });
}

//会員登録ページへ
const register = () => {
    router.push({ name: "register" });
}

//ログアウト
const logout = async () => {
    localStorage.removeItem('token');
    router.push({ name: "item" });
}

//マイページ画面へ
const myPage = () => {
    router.push({ name: "my_page" });
}

const searchKeyword = ref('');

</script>

<template>
    <div class="header">
        <img class="header_img" :src="logo" alt="Header Image" />
        <input class="search_Keyword" placeholder="なにをお探しですか？" v-model="searchKeyword">
        <button class="login_button" v-if="!isLoggedIn" @click="login">ログイン</button>
        <button class="register_button" v-if="!isLoggedIn" @click="register">会員登録</button>
        <button class="logout_button" v-if="isLoggedIn" @click="logout">ログアウト</button>
        <button class="myPage_button" v-if="isLoggedIn" @click="myPage">マイページ</button>
        <button class="sell_button">出品</button>
    </div>
</template>

<style>
.header {
    display: flex;
    justify-content: space-between;
    text-align: center;
    width: 100%;
    background-color: black;
}
.header_img {
    max-width: 100%;
    height: auto;
    padding: 20px;
}
.search_Keyword{
    width: 400px;
    margin: 15px;
    border-radius: 3px;
    border: none;
}
.login_button, .register_button, .logout_button, .myPage_button{
    border-radius: 3px;
    border: none;
    background-color: black;
    color: white;
    cursor: pointer;
}
.sell_button{
    width: 80px;
    margin: 15px;
    border-radius: 3px;
    border: none;
    cursor: pointer;
}
</style>