<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Header from './Header.vue';

const user = ref({
    name: '',
    icon: '',
    post_number: '',
    address: '',
    building_name: ''
});
const router = useRouter();
const placeholderImage = 'path/to/placeholder/image.png';

onMounted(async () => {
    try {
        const response = await axios.get('http://localhost/api/my_page/me');
        const userData = response.data.data;  // ここで userData を定義

        user.value = {
            name: userData.name ?? '',
            icon: userData.icon ?? '',
            post_number: userData.post_number ?? '',
            address: userData.address ?? '',
            building_name: userData.building_name ?? ''
        };
    } catch (error) {
        console.error('ユーザーデータの取得に失敗しました:', error);
    }
});

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            user.value.icon = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const updateProfile = async () => {
    try {
        await axios.put('http://localhost/api/my_page/me', user.value);
        alert('プロフィールが更新されました');
        router.push({ name: "my_page" }); //マイページへ
    } catch (error) {
        console.error('更新に失敗しました:', error);
        alert('更新に失敗しました');
    }
};

</script>

<template>
    <Header />
    <div class="profile_edit">
        <h2 class="page_title">プロフィール設定</h2>
        <form @submit.prevent="updateProfile">
            <div class="form_group-profile">
                <img :src="user.icon || placeholderImage" alt="User Icon" class="user_icon" />
                <label for="icon_upload" class="image_upload">
                    画像を選択する
                </label>
                <input type="file" id="icon_upload" @change="handleImageUpload" style="display: none;" />
            </div>
            <div class="form_group-name">
                <label class="input_title" for="name">ユーザー名</label>
                <input type="text" id="name" v-model="user.name" required class="input_contents" />
            </div>
            <div class="form_group-number">
                <label class="input_title" for="post_number">郵便番号</label>
                <input type="text" id="post_number" v-model="user.post_number" class="input_contents" />
            </div>
            <div class="form_group-address">
                <label class="input_title" for="address">住所</label>
                <input type="text" id="address" v-model="user.address" class="input_contents" />
            </div>
            <div class="form_group-building_name">
                <label  class="input_title" for="building_name">建物名</label>
                <input type="text" id="building_name" v-model="user.building_name" class="input_contents" />
            </div>
            <button type="submit" class="update_button">更新する</button>
        </form>
    </div>
</template>

<style>
.profile_edit {
    max-width: 600px;
    margin: 0 auto;
    text-align: left;
}
.page_title {
    margin-bottom: 20px;
    text-align: center;
}
.form_group-profile {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.user_icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin-right: 30px;
}
.image_upload {
    padding: 6px 12px;
    cursor: pointer;
    border: 1px solid #ccc;
    color: rgba(255, 0, 0, 0.670);
    background-color: white;
    border-radius: 4px;
}
.form_group-name,
.form_group-number,
.form_group-address,
.form_group-building_name{
    margin-bottom: 30px;
}
.input_title{
    font-weight: bold;
}
.input_contents {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    box-sizing: border-box;
}
.update_button {
    padding: 10px 20px;
    background-color: rgba(255, 0, 0, 0.670);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-self: center;
}
.update_button:hover {
    background-color: darkred;
}
</style>