<template>
    <div class="order-confirmation">
        <q-btn flat icon="arrow_back" label="Quay lại" @click="goBack" class="back-button" />
        <div class="header">
            <p class="header-title">Xác nhận đơn hàng</p>
        </div>
        <div class="order-steps">
            <q-stepper vertical animated>
                <q-step name="1" done="true" title="Tiếp nhận" />
                <q-step name="2" title="Chốt đơn" />
                <q-step name="3" title="Đang giao" />
                <q-step name="4" title="Hoàn tất" />
            </q-stepper>
        </div>
        <div class="address-section">
            <p class="address-title">Địa chỉ Người nhận</p>
            <q-input filled v-model="orderInfo.shippingAddress" label="Địa chỉ nhận hàng" />
        </div>
        <div class="product-summary">
            <q-avatar>
                <img src="/images/slide/slider-1.jpg" class="thumbnail">
            </q-avatar>
            <p>{{ product.name }}</p>
        </div>
        <p class="shipping">Phương thức Giao hàng</p>
        <div class="shipping-method-selection">
            <q-select v-model="orderInfo.selectedShippingMethod" :options="shippingMethods"
                label="Phương thức giao hàng" filled />
        </div>
    </div>
    <div class="action-button">
        <q-btn label="Đặt Hàng" color="orange" :disable="!orderInfo.canPlaceOrder" @click="backToHomePage" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useQuasar } from 'quasar';

const router = useRouter();
const route = useRoute();
const $q = useQuasar();
const buyer_id = $q.localStorage.getItem('id');

const orderInfo = ref({
    shippingAddress: '',
    selectedShippingMethod: '',
    productName: 'Product 1',
    canPlaceOrder: true,
});
const product = ref({});

const fetchProduct = async (id) => {
    try {
        const response = await fetch(`https://school-supplies-exchange.taiyo.space/api/products/${id}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        product.value = data;
    } catch (error) {
        console.error('Error fetching product:', error);
    }
};

if (!buyer_id || buyer_id == null) {
    alert('Vui lòng đăng nhập để trao đổi sản phẩm');
    router.push('/profile');
}

async function placeOrder() {
    const orderData = {
        buyer_id: buyer_id,
        seller_id: product.value.user_id,
        product_id: route.params.id,
    };

    try {
        const response = await fetch('https://school-supplies-exchange.taiyo.space/api/bills', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        return true;
    } catch (error) {
        console.error('Error placing order:', error);
        return false;
    }
};

const shippingMethods = ref([
    { label: 'Giao hàng tiết kiệm - 20k', value: 'economy' },
    { label: 'Tiêu chuẩn - 30k', value: 'standard' },
    { label: 'Giao hàng nhanh - 50k', value: 'fast' },
    { label: 'Giao hàng hỏa tốc - 60k', value: 'express' },
]);

onMounted(async () => {
    const productId = route.params.id;
    await fetchProduct(productId);

    console.log("buyer_id");
    console.log(buyer_id);
    console.log(product.value.user_id);

    if (buyer_id == product.value.user_id) {
        alert('Không thể trao đổi sản phẩm với chính mình');
        router.push('/');
    }
});

const goBack = () => {
    router.back();
};

const backToHomePage = () => {
    if (placeOrder()) {
        router.push('/');
    }
};
</script>
<style scoped>
.order-confirmation {
    padding: 16px;
}

.header-title {
    font-size: 30px;
    text-align: center;
    font-weight: 500;
}

.payment-banner {
    display: flex;
    align-items: center;
    padding: 16px;
}

.order-steps {
    margin-top: 16px;
    margin-bottom: 16px;
}

.address-section {
    margin-top: 16px;
}

.address-title {
    font-size: 18px;
    font-weight: 500;
}

.product-summary {
    display: flex;
    align-items: center;
    justify-items: center;
}

.product-summary p {
    font-size: 18px;
    font-weight: 500;
    padding: 10px 20px 10px 20px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
}

.price {
    font-size: 18px;
    color: #d32f2f;
}

.payment-summary {
    margin-top: 16px;
}

.action-button {
    margin: 0px 0px 16px 0px;
    display: flex;
    justify-content: center;
}
</style>