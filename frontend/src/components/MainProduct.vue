<template>
    <div style="margin-top: 40px;">
        <p class="product-text-title">Sản Phẩm Hôm nay</p>
        <div class="product-container">
            <q-card class="my-card" v-for="(product, index) in products" :key="index"
                @click="goToProductDetail(product.id)">
                <img src="/images/slide/slider-1.jpg" class="thumbnail">

                <q-card-section>
                    <div class="text-h6">{{ product.name }}</div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="around">
                    <q-btn flat>{{ product.description }}</q-btn>
                </q-card-actions>
            </q-card>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const products = ref([]);

function goToProductDetail(id) {
    router.push(`/product/${id}`);
}

const api = "https://phuctph.name.vn/api/products";

const fetchProducts = async () => {
    try {
        const response = await fetch(api);
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
</style>