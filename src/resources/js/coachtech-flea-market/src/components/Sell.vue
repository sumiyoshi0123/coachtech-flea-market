<script setup>
import { ref, onMounted } from 'vue';
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const userId = ref(null);
const itemName = ref('');
const itemBrand = ref('');
const itemDescription = ref('');
const itemPrice = ref('');
const categories = ref([]);
const conditions = ref([]);
const category = ref(categories.value.length > 0 ? categories.value[0].id : null);
const condition = ref(conditions.value.length > 0 ? conditions.value[0].id : null);
const imageUrl = ref(null);
const imageFile = ref(null); // 画像ファイルを保存するための変数

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        imageFile.value = file; // 画像ファイルをimageFileに設定
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

//出品処理
const submitItem = async () => {
    try {
        const formData = new FormData();
        formData.append('user_id', userId.value);
        formData.append('name', itemName.value);
        formData.append('brand', itemBrand.value);
        formData.append('description', itemDescription.value);
        formData.append('price', itemPrice.value);
        // categoryとconditionがnullでないことを確認してから追加
        if (category.value !== null) {
            formData.append('category_id', category.value);
        }
        if (condition.value !== null) {
            formData.append('condition_id', condition.value);
        }
        if (imageFile.value) {
            formData.append('image', imageFile.value);
        }

        const response = await axios.post("http://localhost/api/item", formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        alert('商品が正常に出品されました！');
        console.log(response.data);
        router.push({ name: "item" });
    } catch (error) {
        alert('出品処理に失敗しました。');
        console.error(error);
    }
};

//カテゴリーの取得
const fetchCategories = async () => {
    try {
        const response = await axios.get("http://localhost/api/categories");
        categories.value = response.data;
    } catch (error) {
        console.error('カテゴリーの取得に失敗しました:', error);
    }
};

//商品状態の取得
const fetchConditions = async () => {
    try {
        const response = await axios.get("http://localhost/api/conditions");
        conditions.value = response.data;
    } catch (error) {
        console.error('商品の状態の取得に失敗しました:', error);
    }
};

// ユーザー情報を取得する関数
const fetchUserInfo = async () => {
    try {
        const response = await axios.get('http://localhost/api/user');
        userId.value = response.data.id; // ユーザーIDを設定
    } catch (error) {
        console.error('ユーザー情報の取得に失敗しました:', error);
    }
};

// コンポーネントのマウント時にデータを取得
onMounted(() => {
    fetchCategories();
    fetchConditions();
    fetchUserInfo();
});
</script>

<template>
    <div class="sell_page">
        <h1 class="page_title">商品の出品</h1>
        <form @submit.prevent="submitItem">
        <div class="form_group">
            <label for="itemImage" class="group_title">商品画像</label>
            <input type="file" id="itemImage" @change="handleFileUpload" class="form_group-input">
            <div v-if="imageUrl">
                <img :src="imageUrl" alt="商品画像" class="preview-image">
            </div>
        </div>

        <div class="section_title">商品の詳細</div>
        <div class="form_group">
            <label for="category" class="group_title">カテゴリー</label>
            <select id="category" v-model="category" class="form_group-select">
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
        <div class="form_group">
            <label for="condition" class="group_title">商品の状態</label>
            <select id="condition" v-model="condition" class="form_group-select">
                <option v-for="cond in conditions" :key="cond.id" :value="cond.id">{{ cond.name }}</option>
            </select>
        </div>

        <div class="section_title">商品名と説明</div>
        <div class="form_group">
            <label for="itemName" class="group_title">商品名</label>
            <input type="text" id="itemName" v-model="itemName" class="form_group-input">
        </div>
        <div class="form_group">
            <label for="itemBrand" class="group_title">ブランド</label>
            <input type="text" id="itemBrand" v-model=itemBrand class="form_group-input">
        </div>
        <div class="form_group">
            <label for="itemDescription" class="group_title">商品の説明</label>
            <textarea id="itemDescription" v-model="itemDescription" class="form_group-textarea"></textarea>
        </div>

        <div class="section_title">販売価格</div>
        <div class="form_group">
            <label for="itemPrice" class="group_title">販売価格</label>
            <div class="price_input">
                <span class="currency_symbol">¥</span>
                <input type="number" id="itemPrice" v-model="itemPrice" class="form_group-input">
            </div>
        </div>

        <button type="submit" class="submit_button">出品する</button>
        </form>
    </div>
</template>

<style scoped>
.sell_page {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}
.page_title {
    text-align: center;
    margin-bottom: 20px;
}
.form_group {
    margin-bottom: 20px;
}
.section_title {
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 1.2em;
    font-weight: bold;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
    color: gray;
}
.group_title {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form_group-input,
.form_group-textarea,
.form_group-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form_group-textarea {
    resize: vertical;
}
.preview_image {
    max-width: 100%;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.price_input {
    position: relative;
    display: flex;
    align-items: center;
}
.currency_symbol {
    position: absolute;
    left: 10px;
    z-index: 1;
    font-size: 1em;
    color: #333;
}
.price_input input {
    padding-left: 20px;
}
.submit_button {
    width: 100%;
    padding: 10px;
    background-color: #ff6347;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.submit_button:hover {
    background-color: #ff4500;
}
</style>
