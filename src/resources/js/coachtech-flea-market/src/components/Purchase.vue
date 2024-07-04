<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
import Header from './Header.vue';

const router = useRouter();
const route = useRoute();

const item = ref({
    id:'',
    name: '',
    price: 0,
    img_url: '',
});

// 価格をカンマ区切りで表示する計算されたプロパティ
const formattedPrice = computed(() => {
    const price = item.value.price;
    if (!Number.isInteger(price)) return '';
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
});

onMounted(async () => {
    const id = route.params.id; // ルートパラメータからidを取得
    const json = await axios.get(`http://localhost/api/item/${id}`);
    const data = json.data;
    item.value = data.data;

    //支払方法の取得
    const paymentResponse = await axios.get('http://localhost/api/payments');
    paymentMethods.value = paymentResponse.data.map(payment => ({
        id: payment.id,
        method: payment.payment
    }));
});

//支払方法の選択
const paymentMethods = ref([]);
const selectedPaymentMethod = ref('');
const showPaymentModal = ref(false);

const selectPaymentMethod = (method) => {
    selectedPaymentMethod.value = method;
    showPaymentModal.value = false;
};

//住所変更ページへ
const changeAddress = () => {
    router.push({ name: 'addressChangeForm' });
};

//購入機能
const purchaseItem = async () => {
    if (!selectedPaymentMethod.value) {
        alert('支払い方法を選択してください');
        return;
    }
    try {
        const response = await axios.post('http://localhost/api/purchase', {
            item_id: item.value.id,
            payment_id: selectedPaymentMethod.value.id,
        });
        if (response.data.success) {
            alert('購入が完了しました');
        } else {
            alert('購入に失敗しました');
        }
    } catch (error) {
        console.error(error);
        alert('購入処理中にエラーが発生しました');
    }
};

</script>

<template>
    <Header />
    <main class="purchase_item">
        <div class="purchase_form">
            <div class="data">
                <img class="image" :src="item.img_url" alt="Image" />
                <div class="item_data">
                    <div class="item_name">{{ item.name }}</div>
                    <div class="item_price">¥{{ formattedPrice }}</div>
                </div>
            </div>
            <div class="payment">
                <p class="payment_title">支払い方法</p>
                <button class="payment_select" @click="showPaymentModal = true">変更する</button>
            </div>
            <div class="destination">
                <p class="destination_title">配送先</p>
                <button class="destination_select" @click="changeAddress">変更する</button>
            </div>
        </div>
        <div class="purchase_data">
            <table class="data_items">
                <tr>
                    <th>商品代金</th>
                    <td>¥{{ formattedPrice }}</td>
                </tr>
                <tr>
                    <th>支払い代金</th>
                    <td>¥{{ formattedPrice }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>{{ selectedPaymentMethod.method }}</td>
                </tr>
            </table>
            <button class="purchase_data-button" @click="purchaseItem">購入する</button>
        </div>

        <!-- 支払い方法モーダル -->
        <div v-if=" showPaymentModal" class="modal">
            <div class="modal-content">
                <h3>支払い方法を選択してください</h3>
                <ul class="payment_list">
                    <li v-for="method in paymentMethods" :key="method" @click="selectPaymentMethod(method)"
                        class="list_item">
                        {{ method .method}}
                    </li>
                </ul>
                <button @click="showPaymentModal = false">閉じる</button>
            </div>
        </div>
    </main>
</template>

<style>
.purchase_item {
    display: flex;
    justify-content: center;
}
.purchase_form {
    display: flex;
    flex-direction: column;
    padding-top: 100px;
}
.data {
    display: flex;
}
.image {
    width: 110px;
    height: 160px;
    padding-left: 20px;
}
.item_data {
    display: flex;
    flex-direction: column;
    padding-top: 30px;
    padding-left: 60px;
    margin-right: 100px;
}
.payment,
.destination {
    display: flex;
    justify-content: space-between;
    margin-bottom: 90px;
}
.payment_title,
.destination_title{
    font-weight: bold;
}
.payment_select,
.destination_select{
    border: none;
    cursor: pointer;
    color: rgb(16, 165, 215);
    background-color: white;
}
.purchase_data{
    display: flex;
    flex-direction: column;
    padding-top: 100px;
    padding-left: 150px;
}
.data_items{
    border: solid 1px black;
    height: 300px;
    width: 350px;
}
.purchase_data-button{
    color: white;
    font-weight: bold;
    cursor: pointer;
    background-color: rgba(255, 0, 0, 0.670);
    border: none;
    width: 350px;
    height: 35px;
    margin-top: 60px;
}
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
}
.payment_list{
    list-style-type: none;
    padding-left: 0;
}
.list_item{
    margin-bottom: 10px;
}
</style>