<script setup>
import { ref } from 'vue';

const itemName = ref('');
const itemDescription = ref('');
const itemPrice = ref('');
const categories = ref([]);
const conditions = ref([]);
const imageUrl = ref(null);
const imageFile = ref(null); // 画像ファイルを保存するための変数

const handleFileUpload = (event) => {
const file = event.target.files[0];
    if (file) {
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
        formData.append('name', itemName.value);
        formData.append('description', itemDescription.value);
        formData.append('price', itemPrice.value);
        formData.append('category_id', category.value);
        formData.append('condition_id', condition.value);
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
    } catch (error) {
        alert('出品処理に失敗しました。');
        console.error(error);
    }
};

// //カテゴリーの取得
// const fetchCategories = async () => {
//     try {
//         const response = await axios.get("http://localhost/api/categories");
//         categories.value = response.data;
//     } catch (error) {
//         console.error('カテゴリーの取得に失敗しました:', error);
//     }
// };

// //商品状態の取得
// const fetchConditions = async () => {
//     try {
//         const response = await axios.get("http://localhost/api/conditions");
//         conditions.value = response.data;
//     } catch (error) {
//         console.error('商品の状態の取得に失敗しました:', error);
//     }
// };

// // コンポーネントのマウント時にデータを取得
// onMounted(() => {
//     fetchCategories();
//     fetchConditions();
// });
</script>

<template>
    <div class="sell_page">
        <h1 class="page_title">商品の出品</h1>
        <form @submit.prevent="submitItem">
        <div class="form_group">
            <label for="itemImage">商品画像</label>
            <input type="file" id="itemImage" @change="handleFileUpload">
            <div v-if="imageUrl">
                <img :src="imageUrl" alt="商品画像" class="preview-image">
            </div>
        </div>

        <div class="section_title">商品の詳細</div>
        <div class="form_group">
            <label for="category">カテゴリー</label>
            <select id="category" v-model="category">
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
        <div class="form_group">
            <label for="condition">商品の状態</label>
            <select id="condition" v-model="condition">
                <option v-for="cond in conditions" :key="cond.id" :value="cond.id">{{ cond.name }}</option>
            </select>
        </div>

        <div class="section_title">商品名と説明</div>
        <div class="form_group">
            <label for="itemName">商品名</label>
            <input type="text" id="itemName" v-model="itemName">
        </div>
        <div class="form_group">
            <label for="itemDescription">商品の説明</label>
            <textarea id="itemDescription" v-model="itemDescription"></textarea>
        </div>

        <div class="section_title">販売価格</div>
        <div class="form_group">
            <label for="itemPrice">販売価格</label>
            <div class="price_input">
                <span class="currency_symbol">¥</span>
                <input type="number" id="itemPrice" v-model="itemPrice">
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
.form_group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form_group input,
.form_group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.form_group textarea {
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
