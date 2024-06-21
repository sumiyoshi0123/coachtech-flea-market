<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

// SVGファイルをimportを使用してインポート
import logo from '../assets/logo.svg';

const email = ref("");
const password = ref("");
const router = useRouter();

const login = async () => {
    const json = await axios.post("http://localhost/api/login", {
        email: email.value,
        password: password.value
    });
    console.log(json.data.token);
    const token = json.data.token;
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
    localStorage.setItem("token", token);
    router.push({ name: "item" });
}

const navigateToRegister = () => {
    router.push({ name: "register" });
}
</script>

<template>
    <header class="header">
        <img class="header_img" :src="logo" alt="Header Image" />
    </header>
    <main>
        <div class="login_form">
            <div class="form-title">
                <p class="form-title_item">ログイン</p>
            </div>
            <div class="form_item">
                <div class="email_form">
                    <p class="form_label">メールアドレス</p>
                    <input type="text" class="item-email" v-model="email">
                </div>
                <div class="pass_form">
                    <p class="form_label">パスワード</p>
                    <input type="text" class="item-pass" v-model="password">
                </div>
                <button class="from_item-button" @click="login()">ログインする</button>
                <a class="link" @click="navigateToRegister">会員登録はこちら</a>
            </div>
        </div>
    </main>
</template>

<style>
.form_item {
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}
.form-title_item{
    font-size: x-large;
    font-weight: bold;
    text-align: center;
}
.form_label{
    font-weight: bold;
    text-align: start;
    margin-bottom: 0;
}
.item-email,
.item-pass{
    width: 300px;
    height: 25px;
}
.from_item-button{
    color: white;
    font-weight: bold;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.670);
    border: none;
    width: 300px;
    height: 30px;
    margin-top: 35px;
}
.link{
    color: rgb(16, 165, 215);
    cursor: pointer;
}
</style>