<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Header from './Header.vue';

const user = ref([]);
const sellItems = ref([]);
const purchaseItems = ref([]);
const router = useRouter();
const activeTab = ref('sell');

onMounted(async () => {
    //ユーザー情報の取得
    const userJson = await axios.get("http://localhost/api/my_page/me");
    const userData = userJson.data.data;
    user.value = userData;

    //出品した商品を取得
    // const sellItemJson = await axios.get("http://localhost/api/item");
    // const sellData = sellItemJson.data;
    // sellItems.value = sellData.itemData;

    // 購入した商品を取得
    const json = await axios.get('http://localhost/api/purchase');
    const purchaseData = json.data.purchases;
    purchaseItems.value = purchaseData;
});

//切り替えタブ
const changeTab = (tab) => {
    activeTab.value = tab;
};

const filteredItems = computed(() => {
    if (activeTab.value === 'sell') {
        return sellItems.value;
    } else if (activeTab.value === 'purchase') {
        return purchaseItems.value;
    }
});

//プロフィール編集画面へ
const goToEditProfile = () => {
    router.push({ name: "profileEdit" });
};

</script>

<template>
    <Header />
    <main>
        <div class="center-container">
            <div class="user_data">
                <div class="icon">
                    <img :src="user.icon" alt="User Icon" class="icon_image" />
                </div>
                <div class="name">{{ user.name }}</div>
                <div class="edit">
                    <button class="edit_button" @click="goToEditProfile">プロフィールを編集</button>
                </div>
            </div>
        </div>
        <div class="tab">
            <div class="tab-item" :class="{ 'active': activeTab === 'sell' }" @click="changeTab('sell')">出品した商品
            </div>
            <div class="tab-item" :class="{ 'active': activeTab === 'purchase' }" @click="changeTab('purchase')">購入した商品
            </div>
        </div>
        <div class="item-list">
            <div class="item" v-for="item in filteredItems" :key="item.id">
                <div @click="goToDetail(item.id)">
                    <img class=" item_image" :src="item.item.img_url" alt="Image" />
                </div>
            </div>
        </div>
    </main>
</template>

<style>
.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 25vh;
}
.user_data{
    text-align: center; /* 中央寄せ */
    display: flex;
    align-items: center;
}
.icon{
    width: 50px;
    height: 50px;
    padding-right: 35px;
}
.name{
    font-weight: bold;
    font-size: x-large;
    padding-right: 250px;
}
.edit {
    display: flex;
    justify-content: flex-end;
    width: 100%;
}
.edit_button{
    background-color: white;
    color: red;
    border: solid 1px red;
    border-radius: 4px;
    cursor: pointer;
}
.tab {
    padding-top: 30px;
    padding-left: 100px;
    margin-bottom: 30px;
    border-bottom: 2px solid #ccc;
}
.tab-item {
    display: inline-block;
    padding: 10px 30px;
    cursor: pointer;
}
.tab-item.active {
    color: red;
    font-weight: bold;
}
.item-list {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    /* 5列に分ける */
    gap: 60px;
    /* アイテム間のスペース */
    margin: 60px;
}
.item {
    border: 1px solid #ccc;
    /* ボーダー */
    box-sizing: border-box;
    /* ボーダーを含めたサイズ計算 */
    cursor: pointer;
    /* マウスカーソルをポインターに変更 */
    margin-top: 20px;
}
.item_image {
    width: 100%;
    height: auto;
    /* アスペクト比を維持 */
    object-fit: cover;
    /* 画像のアスペクト比を維持しながらサイズを調整 */
}
</style>