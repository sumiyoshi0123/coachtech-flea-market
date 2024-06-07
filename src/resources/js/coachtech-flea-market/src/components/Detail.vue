<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Header from './Header.vue';
import { nl2br } from '../utils.js';

const item = ref({
    name: '',
    price: 0,
    description: '',
    img_url: '',
    like: false // 初期状態としてお気に入りの状態を持つ
});

const router = useRouter();
const route = useRoute();

const formattedDescription = computed(() => {
    // 改行文字の置換処理
    const description = item.value.description ? item.value.description.replace(/\\n/g, '\n') : '';
    return description ? nl2br(description) : '';
});

// 価格をカンマ区切りで表示する計算されたプロパティ
const formattedPrice = computed(() => {
    return item.value.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});

onMounted(async () => {
    const id = route.params.id;
    const json = await axios.get(`http://localhost/api/item/${id}`);
    const data = json.data;
    item.value = data.data;
});

//マイリスト登録
const toggleLike = async () => {
    const response = await axios.post('http://localhost/api/like', { item_id: item.value.id });
    if (response.data.message === 'Like Record') {
        item.value.like = true;
    } else if (response.data.message === 'Like Cancel') {
        item.value.like = false;
    }
}

//コメントページへ

//購入ページへ

</script>

<template>
    <Header />
    <main class="detail_index">
        <img class="item_img" :src="item.img_url" alt="Image" />
        <div class="item_data">
            <div class="item_name">{{ item.name }}</div>
            <div class="item_price">¥{{ formattedPrice }}</div>
            <div class="button_icon">
                <button class="like_button" @click="toggleLike(item.id)">
                    <img v-if="item.like" class="button_image" src="../img/star_fill.jpg" alt="Like Icon" />
                    <img v-else class="button_image" src="../img/star.jpg" alt="Like Icon" />
                </button>
                <button class="comment_button">
                    <img class="button_image" src="../img/chat_bubble.jpg" alt="Comment Icon">
                </button>
            </div>
            <button class="purchase_button">購入する</button>
            <div class="item_description">
                <p class="description_title">商品説明</p>
                <div class="description" v-html="formattedDescription"></div>
            </div>
            <div class="item_information">
                <p class="information_title">商品の情報</p>
                <div class="item_category">
                    <p>カテゴリー</p>
                    <div class="category_tag"></div>
                </div>
                <div class="item_condition">
                    <p>商品の状態</p>
                    <div class="condition_tag"></div>
                </div>
            </div>
        </div>
    </main>
</template>

<style>
.detail_index{
    display: flex;
    padding-top: 100px;
    justify-content: center;
}
.item_img{
    width: 25%;
    height: auto; /* アスペクト比を維持 */
    object-fit: cover; /* 画像のアスペクト比を維持しながらサイズを調整 */
}
.item_data{
    display: flex;
    flex-direction: column;
    padding-left: 100px;
}
.description {
    white-space: pre-wrap;
}
.item_name{
    font-size: xx-large;
    font-weight: bold;
}
.button_icon {
    display: flex;
    gap: 10px; /* ボタン間のスペースを設定 */
}
.like_button,
.comment_button {
    border: none;
    background: none;
    cursor: pointer;
    display: flex; /* ボタン内の内容を横並びにする */
    align-items: center; /* ボタン内の要素を中央揃えにする */
}
.button_image {
    width: 24px;
    height: 24px;
}
.purchase_button{
    color: white;
    font-weight: bold;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.670);
    border: none;
    width: 200px;
    height: 25px;
}
.description_title, .information_title{
    font-size: x-large;
    font-weight: bold;
}

</style>