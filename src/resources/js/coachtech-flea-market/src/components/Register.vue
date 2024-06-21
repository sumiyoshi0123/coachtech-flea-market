<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

// SVGファイルをimportを使用してインポート
import logo from '../assets/logo.svg';

const email = ref("");
const password = ref("");
const router = useRouter();

const register = async () => {
    const json = await axios.post("http://localhost/api/register", {
        email: email.value,
        password: password.value
    });
    router.push({ name: "login" });
}

const navigateToLogin = () => {
    router.push({ name: "login" });
}
</script>

<template>
    <header class="header">
        <img class="header_img" :src="logo" alt="Header Image" />
    </header>
    <main>
        <div class="register_form">
            <div class="form-title">
                <p class="form-title_item">会員登録</p>
            </div>
            <div class="form_item">
                <div class="email_form">
                    <p class="form_label">メールアドレス</p>
                    <input type="text" class="item-email" v-model="email">
                </div>
                <div class="pass_form">
                    <p class="form_label">パスワード</p>
                    <input type="password" class="item-pass" v-model="password">
                </div>
                <button class="form_button" @click="register">登録する</button>
                <a class="link_button" @click="navigateToLogin">ログインはこちら</a>
            </div>
        </div>
    </main>
</template>

<style>
.form_item {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 50px;
}
.form-title_item {
    font-size: x-large;
    font-weight: bold;
    text-align: center;
}
.form_label {
    font-weight: bold;
    text-align: start;
    margin-bottom: 5px;
}
.item-email,
.item-pass {
    width: 300px;
    height: 25px;
    margin-bottom: 15px;
    padding: 5px;
}
.form_button {
    color: white;
    font-weight: bold;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.670);
    border: none;
    width: 300px;
    height: 30px;
    margin-top: 35px;
}
.link_button {
    color: rgb(16, 165, 215);
    cursor: pointer;
}
</style>