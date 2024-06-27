<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const address = ref({
    post_number: '',
    address: '',
    building_name: ''
});

const updateAddress = async () => {
    try {
        const response = await axios.post('http://localhost/api/my_page', address.value);
        if (response.status === 200) {
            alert('住所が更新されました。');
            router.push({ name: 'purchase' }); // 注文ページにリダイレクト
        }
    } catch (error) {
        console.error('住所の更新に失敗しました:', error);
        alert('住所の更新に失敗しました。');
    }
};
</script>

<template>
    <div class="address-change">
        <h2 class="form_title">住所の変更</h2>
        <form @submit.prevent="updateAddress">
            <div class="form-group">
                <label class="form_content" for="post_number">郵便番号</label>
                <input class="form_input" type="text" id="post_number" v-model="address.post_number" required />
            </div>
            <div class="form-group">
                <label class="form_content" for="address">住所</label>
                <input class="form_input" type="text" id="address" v-model="address.address" required />
            </div>
            <div class="form-group">
                <label class="form_content" for=" building_name">建物名</label>
                <input class="form_input" type="text" id="building_name" v-model="address.building_name" />
            </div>
            <button class="update_button" type="submit">更新する</button>
        </form>
    </div>
</template>

<style>
.address-change {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}
.form_title {
    text-align: center;
}
.form-group {
    margin-bottom: 20px;
}
.form_content {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}
.form_input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
.update_button {
    width: 100%;
    padding: 10px;
    background-color: rgba(255, 0, 0, 0.670);
    color: #fff;
    border: none;
    cursor: pointer;
    margin-top: 30px;
}
</style>
