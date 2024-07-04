<script setup>
import { ref, reactive, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Header from './Header.vue';

const item = ref({
    name: '',
    brand: '',
    price: 0,
    description: '',
    img_url: '',
    likes: false // 初期状態としてお気に入りの状態を持つ
});

const comments = ref([]);
const newComment = reactive({
    user_icon: '',
    user_name: '',
    user_comment: ''
});

const user = ref(null); // ログインユーザー情報を保持するオブジェクト

const likesCount = ref(0);
const commentsCount = ref(0);
const router = useRouter();
const route = useRoute();

// 価格をカンマ区切りで表示する計算されたプロパティ
const formattedPrice = computed(() => {
    const price = item.value.price;
    if (typeof price !== 'number') return '';
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});

onMounted(async () => {
    // idを整数に変換
    const id = parseInt(route.params.id, 10);

    const json = await axios.get(`http://localhost/api/item/${id}`);
    const data = json.data;
    item.value = data.data;

    const likeItems = await axios.get("http://localhost/api/like");
    // アイテムIDのみを抽出
    const likes = likeItems.data.likes.map(like => like.item_id);
    // like配列にアイテムIDが含まれているかをチェック
    item.value.likes = likes.includes(id);

    //マイリスト件数を取得
    const likesResponse = await axios.get(`http://localhost/api/item/${id}/likes-count`);
    likesCount.value = likesResponse.data.likes_count;

    // コメント情報を取得
    const commentsResponse = await axios.get(`http://localhost/api/comments/${id}`);
    comments.value = commentsResponse.data.comments;
    commentsCount.value = commentsResponse.data.comments.length;

    // ログインユーザーを取得
    const userResponse = await axios.get("http://localhost/api/user");
    if (userResponse.data) {
        user.value = userResponse.data;
    }
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

// コメント登録
const addComment = async () => {
        const id = parseInt(route.params.id, 10);

        const response = await axios.post('http://localhost/api/comments', {
            item_id: id,
            comment: newComment.user_comment
        });

        //コメント送信後の処理
        if (response.status === 201) {
            // 新しいコメントをcommentsリストに追加
            comments.value.push({
                user_icon: user.value.icon,  // ユーザーアイコンを追加
                user_name: user.value.name,  // ユーザー名を追加
                comment: newComment.user_comment
            });
            commentsCount.value += 1; // コメント数を更新
            newComment.user_comment = ''; // フィールドをクリアにする
        }
};

// コメント削除
const deleteComment = async (commentId) => {
    const response = await axios.delete(`http://localhost/api/comments/${commentId}`);

    if (response.status === 200) {
        comments.value = comments.value.filter(comment => comment.id !== commentId);
        commentsCount.value -= 1; // コメント数を更新
    }
};
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
                    <button class="comment_button">
                        <img class="button_image" src="../img/chat_bubble.jpg" alt="Comment Icon">
                    </button>
                    <span class="comment_count">{{ commentsCount }}</span>
                </div>
            </div>
            <div class="comment_index">
                <div class="users_comment" v-for="comment in comments" :key="comment.id">
                    <div class="user_data">
                        <div class="comment-user_icon">
                            <img :src="comment.user_data.icon" alt="User Icon" class="icon_image" />
                        </div>
                        <div class="user_name">{{ comment.user_data.name }}</div>
                    </div>
                    <div class="comment_body">
                        <div class="user_comment">{{ comment.comment }}</div>
                        <button class="delete_button" v-if="user && comment.user_id === user.id"
                            @click="deleteComment(comment.id)">
                            <img class="delete_icon" src="../img/multiply_circle.png">
                        </button>
                    </div>
                </div>
            </div>
            <div class="comment_form">
                <div class="comment_form-title">商品へのコメント</div>
                <form @submit.prevent="addComment" class="form_contents">
                    <textarea v-model="newComment.user_comment" type="text" class="form_text"></textarea>
                    <button type="submit" class="comment_form-button">コメントを送信する</button>
                </form>
            </div>
        </div>
    </main>
</template>

<style>
/* item */
.detail_index{
    display: flex;
    padding-top: 100px;
    justify-content: center;
}
.item_img{
    width: 25%;
    height: 380px;
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
.item_brand{
    font-size: small;
}
.item_price{
    margin-top: 10px;
}

/* like_button,comment_button */
.button_icon {
    display: flex;
    gap: 10px; /* ボタン間のスペースを設定 */
    margin-top: 10px;
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

/* comment */
.comment_index{
    padding-top: 50px;
}
.users_comment{
    display: flex;
    flex-direction: column;
    margin-bottom: 25px;
}
.user_data{
    display: flex;
    align-items: center; /* アイコンと名前を中央揃え */
    gap: 10px; /* アイコンと名前の間に10pxのスペースを追加 */
}
.comment-user_icon{
    height: 50px;
}
.icon_image {
    border-radius: 50%; /* 丸いアイコンにする */
    width: 40px; /* アイコンの幅 */
    height: 40px; /* アイコンの高さ */
}
.user_name {
    font-weight: bold;
}
.comment_body{
    display: flex;
    justify-content: space-between;
    border: 1px solid #ccc; /* ボーダー */
    box-sizing: border-box;   /* ボーダーを含めたサイズ計算 */
    background-color: rgb(233, 233, 233);
}
.delete_button{
    border: none;
    background: none;
    cursor: pointer;
}
.delete_icon{
    width: 20px;
    height: 20px;
}

/* comment_form */
.comment_form-title{
    padding-top: 30px;
    font-weight: bold;
}
.form_contents{
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.form_text {
    width: 200px;
    height: 100px; /* テキストエリアの高さを調整 */
    resize: none; /* ユーザーがサイズを変更できないようにする */
}
.comment_form-button {
    color: white;
    font-weight: bold;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.670);
    border: none;
    width: 200px;
    height: 25px;
}
</style>