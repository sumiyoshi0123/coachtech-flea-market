<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Header from './Header.vue';

const route = useRoute();

const item = ref({
    name: '',
    price: 0,
    img_url: '',
});

// 価格をカンマ区切りで表示する計算されたプロパティ
const formattedPrice = computed(() => {
    const price = item.value.price;
    if (typeof price !== 'number') return '';
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});

onMounted(async () => {
    const id = route.params.id; // ルートパラメータからidを取得
    const json = await axios.get(`http://localhost/api/item/${id}`);
    const data = json.data;
    item.value = data.data;
});

</script>

<template>
    <Header />
    <main class="detail_index">
        <img class="item_img" :src="item.img_url" alt="Image" />
        <div class="item_data">
            <div class="item_name">{{ item.name }}</div>
            <div class="item_price">¥{{ formattedPrice }}</div>
        </div>
    </main>
</template>

<style>
.detail_index {
    display: flex;
    padding-top: 100px;
    justify-content: center;
}
.item_img {
    width: 25%;
    height: 380px;
    /* アスペクト比を維持 */
    object-fit: cover;
    /* 画像のアスペクト比を維持しながらサイズを調整 */
}
</style>