<template>
    <q-page class="q-pa-md">
        <q-card>
            <q-card-section>
                <div class="text-h6">Sản phẩm đã đăng</div>
            </q-card-section>

            <q-card-section>
                <q-list bordered separator>
                    <q-item v-for="(product, index) in products" :key="index" class="q-py-md" clickable
                        @click="goToDetail(product.id)">
                        <q-item-section avatar>
                            <q-avatar>
                                <img src="/images/hajime.jpg" alt="User Avatar" />
                            </q-avatar>
                        </q-item-section>

                        <q-item-section>
                            <q-item-label class="text-weight-bold">{{ product.name }}</q-item-label>
                            <q-item-label caption>
                                <q-icon name="person" size="xs" /> Người bán: {{ product.user }}
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="school" size="xs" /> Trường: XYZ
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="attach_money" size="xs" /> Giá: {{ formatPrice(product.price) }} VNĐ
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="event" size="xs" /> Ngày mua: {{ formatDate(product.created_at) }}
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { format } from 'date-fns';
import { useRouter, useRoute } from 'vue-router';
const router = useRouter();
const route = useRoute();
const title = ref('');
const products = ref([])

const formatDate = (dateString) => {
    return format(new Date(dateString), 'dd/MM/yyyy HH:mm');
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('vi-VN').format(price);
}

const fetchProducts = async () => {
    const temporaryToken = localStorage.getItem('token');
    try {
        const response = await fetch(`https://school-supplies-exchange.taiyo.space/api/products/user/postProduct`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${temporaryToken}`
            },
        });
        if (!response.ok) {
            const errorData = await response.text();
            console.error('Error:', errorData);
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        products.value = data;
    } catch (error) {
        console.error('Error fetching bills:', error);
    }
};

const goToDetail = (id) => {
    router.push('/edit-product/' + id);
}

onMounted(() => {
    fetchProducts();
});
</script>

<style scoped>
.q-item {
    transition: background-color 0.3s;
}

.q-item:hover {
    background-color: #f5f5f5;
}
</style>