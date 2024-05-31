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
    router.push({ name: "login" });
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
        <input class="search_Keyword" placeholder="何をお探しですか？" v-model="searchKeyword">
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
    text-align: center;
    padding: 20px;
}

.header_img {
    max-width: 100%;
    height: auto;
}
</style>