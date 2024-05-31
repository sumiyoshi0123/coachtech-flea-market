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
            <div class="from_item">
                <div class="name_form">
                    <p></p>
                </div>
                <div class="email_form">
                    <p>メールアドレス</p>
                    <input type="text" class="item-email" v-model="email">
                </div>
                <div class="pass_form">
                    <p>パスワード</p>
                    <input type="password" class="item-pass" v-model="password">
                </div>
            </div>
            <button class="from_item-button" @click="register">登録する</button>
            <a class="link" @click="navigateToLogin">ログインはこちら</a>
        </div>
    </main>
</template>