<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Header from './Header.vue';
import { nl2br } from '../utils.js';

const item = ref({
    name: '',
    brand: '',
    price: 0,
    description: '',
    img_url: '',
    likes: false, // 初期状態としてお気に入りの状態を持つ
    category: null,
    condition: null
});

const likesCount = ref(0);
const commentsCount = ref(0);
const router = useRouter();
const route = useRoute();

const formattedDescription = computed(() => {
    // 改行文字の置換処理
    const description = item.value.description ? item.value.description.replace(/\\n/g, '\n') : '';
    return description ? nl2br(description) : '';
});

// 価格をカンマ区切りで表示する計算されたプロパティ
const formattedPrice = computed(() => {
    const price = item.value.price;
    if (typeof price !== 'number') return '';
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});

///カテゴリーと商品状態
const categoryName = computed(() => item.value.category ? item.value.category.name : '');
const conditionName = computed(() => item.value.condition ? item.value.condition.name : '');

onMounted(async () => {
    // idを整数に変換
    const id = parseInt(route.params.id, 10);

    const json = await axios.get(`http://localhost/api/item/${id}`);
    const data = json.data;
    item.value = data.data;
    console.log(item.value);

    //マイリスト情報を取得
    const likeItems = await axios.get("http://localhost/api/like");
    // アイテムIDのみを抽出
    const likes = likeItems.data.likes.map(like => like.item_id);
    // like配列にアイテムIDが含まれているかをチェック
    item.value.likes = likes.includes(id);

    //マイリスト件数を取得
    const likesResponse = await axios.get(`http://localhost/api/item/${id}/likes-count`);
    likesCount.value = likesResponse.data.likes_count;

    // コメント件数を取得
    const commentsResponse = await axios.get(`http://localhost/api/comments/${id}`);
    commentsCount.value = commentsResponse.data.comments.length;
});

//マイリスト登録
const toggleLike = async () => {
    const newLikeState = !item.value.likes;
    const response = await axios.post('http://localhost/api/like', {
        item_id: item.value.id,
        like: newLikeState
    });

    if (response.data.message === 'Like Record' || response.data.message === 'Like Cancel') {
        item.value.likes = newLikeState;
        likesCount.value += 1;  // Likeが登録された場合はカウントを増やす
    } else if (response.data.message === 'Like Cancel') {
        item.value.likes = newLikeState;
        likesCount.value -= 1;  // Likeが取り消された場合はカウントを減らす
    }
}

//コメントページへ
const comment = () => {
    router.push({ name: "comment", params: { id: item.value.id } });
}

//購入ページへ
const purchase = () => {
    router.push({ name: "purchase", params: { id: item.value.id } });
}
</script>

<template>
    <Header />
    <main class="detail_index">
        <img class="item_img" :src="item.img_url" alt="Image" />
        <div class="item_data">
            <div class="item_name">{{ item.name }}</div>
            <div class="item_brand">{{ item.brand }}</div>
            <div class="item_price">¥{{ formattedPrice }}</div>
            <div class="button_icon">
                <div class="like_icon">
                    <button class="like_button" @click="toggleLike">
                        <img v-if="item.likes" class="button_image" src="../img/star_fill.jpg" alt="Like Icon" />
                        <img v-else class="button_image" src="../img/star.jpg" alt="Like Icon" />
                    </button>
                    <span class="like_count">{{ likesCount }}</span>
                </div>
                <div class="comment_icon">
                    <button class="comment_button" @click="comment">
                        <img class="button_image" src="../img/chat_bubble.jpg" alt="Comment Icon">
                    </button>
                    <span class="comment_count">{{ commentsCount }}</span>
                </div>
            </div>
            <button class="purchase_button" @click="purchase">購入する</button>
            <div class="item_description">
                <p class="description_title">商品説明</p>
                <div class="description" v-html="formattedDescription"></div>
            </div>
            <div class="item_information">
                <p class="information_title">商品の情報</p>
                <div class="item_category">
                    <p>カテゴリー</p>
                    <div class="category_tag">{{ categoryName }}</div>
                </div>
                <div class="item_condition">
                    <p>商品の状態</p>
                    <div class="condition_tag">{{ conditionName }}</div>
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
    height: 380px; /* アスペクト比を維持 */
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
.item_brand {
    font-size: small;
}
.item_price {
    margin-top: 10px;
}

.button_icon {
    display: flex;
    gap: 10px; /* ボタン間のスペースを設定 */
}
.like_icon,
.comment_icon {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.like_count,
.comment_count{
    font-size: 10px;
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
    margin-top: 10px;
}
.description_title, .information_title{
    font-size: x-large;
    font-weight: bold;
}
.item_category,
.item_condition{
    display: flex;
}
.category_tag,
.condition_tag{
    margin: 16px 30px;
}
</style>