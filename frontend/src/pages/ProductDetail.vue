<template>
    <div class="product-details">
        <q-btn flat icon="arrow_back" label="Quay lại" @click="goBack" class="back-button" />
        <div class="product-header">
            <img :src="product.image ? product.image : '/images/slide/slider-1.jpg'" class="thumbnail">
        </div>
        <div class="product-info">
            <div class="product-title">
                <p>{{ product.name }}</p>
            </div>
            <div class="product-meta">
                <div class="category">
                    <q-icon name="category" /> Danh mục: {{ product.category_name }}
                </div>
                <div class="condition">
                    <q-icon name="check_circle" /> Tình trạng: {{ product.condition == 0 ? 'Mới' : 'Cũ' }}
                </div>
                <div class="price">
                    <q-icon name="attach_money" /> Giá mua vào: {{ product.price }} vnđ
                </div>
                <div class="description">
                    <q-icon name="description" /> Mô tả: {{ product.description }}
                </div>
            </div>
            <div class="">
                <div class="location">
                    <q-icon name="place" /> Hà nội
                </div>
                <div class="time">{{ product.created_at }}</div>
            </div>
            <div class="seller-info">
                <div class="seller-name">{{ product.user }}</div>
                <div class="seller-details">
                    <span>Phản hồi: {{ product.seller?.feedback }}</span> | <span>{{ product.seller?.itemsExchanged }}
                        đồ
                        dùng đã trao lại</span>
                </div>
                <div class="seller-activity">Hoạt động 10p trước</div>
            </div>
        </div>
        <div class="actions">
            <q-btn label="Gọi" color="primary" />
            <q-btn label="SMS" color="primary" />
            <q-btn label="Chat" color="primary" />
            <q-btn label="Trao đổi" color="green" @click="goToPaid(product.id)" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { format } from 'date-fns';

const router = useRouter();
const route = useRoute();
const selectedImage = ref(0);
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

const fetchCategory = async (id) => {
    try {
        const response = await fetch(`https://school-supplies-exchange.taiyo.space/api/categories/${id}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        product.value.category_name = data.name;
    } catch (error) {
        console.error('Error fetching category:', error);
    }
};

onMounted(async () => {
    const productId = route.params.id;
    await fetchProduct(productId);
    await fetchCategory(product.value.category_id);
    product.value.created_at = format(new Date(product.value.created_at), 'dd/MM/yyyy');
});

const goBack = () => {
    router.back();
};

function goToPaid(id) {
    router.push(`/paid/${id}`);
}

</script>

<style scoped>
.thumbnail {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.product-details {
    padding: 16px;
}

.product-meta {
    margin-top: 10px;
}

.product-meta>div {
    margin-bottom: 5px;
}

.product-details img {
    border-radius: 16px;
}

.back-button {
    margin-bottom: 16px;
}

.product-header {
    margin-bottom: 16px;
}

.product-carousel img {
    width: 100%;
    height: 50%;
}

.product-carousel {
    height: 10%;
}

.product-title p {
    font-size: x-large;
    font-weight: 600;
}

.actions {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 16px;
}

.location,
.time {
    font-size: 14px;
    color: #888;
}

.seller-info {
    margin-top: 16px;
}

.seller-details {
    font-size: 14px;
    color: #888;
}

.seller-activity {
    font-size: 12px;
    color: #888;
}

.payment-info {
    margin-top: 16px;
}

.payment-banner {
    display: flex;
    align-items: center;
    padding: 16px;
}
</style>