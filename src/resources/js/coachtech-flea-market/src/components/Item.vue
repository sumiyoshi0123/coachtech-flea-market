<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Header from './Header.vue';

const items = ref([]);
const myList = ref([]);
const router = useRouter();
const activeTab = ref('all');

onMounted(async () => {
    const json = await axios.get("http://localhost/api/item");
    const data = json.data;
    items.value = data.itemData;

    // マイリストのアイテムを取得
    const myListJson = await axios.get('http://localhost/api/like');
    myList.value = myListJson.data.likes.map(like => like.item); // itemオブジェクトのリストに変換
});

//Detail.vueへ
const goToDetail = (itemId) => {
    router.push({ name: 'detail', params: { id: itemId } });
};

//切り替えタブ
const changeTab = (tab) => {
    activeTab.value = tab;
};

const filteredItems = computed(() => {
    if (activeTab.value === 'all') {
        return items.value;
    } else if (activeTab.value === 'myList') {
        return myList.value;
    }
});
</script>

<template>
    <Header />
    <main>
        <div class="tab">
            <div class="tab-item" :class="{ 'active': activeTab === 'all' }" @click="changeTab('all')">おすすめ
            </div>
            <div class="tab-item" :class="{ 'active': activeTab === 'myList' }" @click="changeTab('myList')">マイリスト
            </div>
        </div>
        <div class="item-list">
            <div class="item" v-for="item in filteredItems" :key="item.id">
                <div @click="goToDetail(item.id)">
                    <img class=" item_image" :src="item.img_url" alt="Image" />
                </div>
            </div>
        </div>
    </main>

</template>

<style>
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
    grid-template-columns: repeat(5, 1fr); /* 5列に分ける */
    gap: 60px; /* アイテム間のスペース */
    margin: 60px;
}
.item {
    border: 1px solid #ccc; /* ボーダー */
    box-sizing: border-box; /* ボーダーを含めたサイズ計算 */
    cursor: pointer; /* マウスカーソルをポインターに変更 */
    margin-top: 20px;
}
.item_image {
    width: 100%;
    height: auto; /* アスペクト比を維持 */
    object-fit: cover; /* 画像のアスペクト比を維持しながらサイズを調整 */
}

</style>