<template>
    <div style="margin-top: 40px;">
        <p class="product-text-title">Sản Phẩm Hôm nay</p>
        <div v-if="products.length > 0" class="product-container">
            <q-card class="my-card" v-for="(product, index) in products" :key="index"
                @click="goToProductDetail(product.id)">
                <img :src="product.image ? product.image : '/images/slide/slider-1.jpg'" class="thumbnail">

                <q-card-section>
                    <div class="text-h6">{{ product.name }}</div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="around">
                    <q-btn flat>{{ product.description }}</q-btn>
                </q-card-actions>
            </q-card>
        </div>
        <div v-else class="no-products">
            <p>Không tìm thấy sản phẩm nào.</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const products = ref([]);

function goToProductDetail(id) {
    router.push(`/product/${id}`);
}

const api = "http://100.109.44.93:8000/api/products";

const fetchProducts = async () => {
    try {
        const searchParam = route.query.search ? `search=${route.query.search}` : '';
        const categoryParam = route.query.category ? `category=${route.query.category}` : '';
        const queryParams = [searchParam, categoryParam].filter(Boolean).join('&');
        const url = queryParams ? `${api}?${queryParams}` : api;

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        products.value = data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

onMounted(() => {
    fetchProducts();
});

watch([() => route.query.search, () => route.query.category], fetchProducts);

defineOptions({
    name: 'MainProduct'
});
</script>

<style scoped>
.thumbnail {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.no-products {
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
    color: #888;
}
</style>