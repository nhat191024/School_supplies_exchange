<template>
    <q-page class="q-pa-md">
        <q-card>
            <q-card-section>
                <div class="text-h6">{{ title }}</div>
            </q-card-section>

            <q-card-section>
                <q-list bordered separator>
                    <q-item v-for="(order, index) in orders" :key="index" class="q-py-md">
                        <q-item-section avatar>
                            <q-avatar>
                                <img src="/images/hajime.jpg" alt="User Avatar" />
                            </q-avatar>
                        </q-item-section>

                        <q-item-section>
                            <q-item-label class="text-weight-bold">{{ order.product?.name }}</q-item-label>
                            <q-item-label caption>
                                <q-icon name="person" size="xs" /> Người bán: {{ order.seller?.name }}
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="school" size="xs" /> Trường: {{ order.seller?.school }}
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="attach_money" size="xs" /> Giá: {{ formatPrice(order.product?.price) }}
                                VNĐ
                            </q-item-label>
                            <q-item-label caption>
                                <q-icon name="event" size="xs" /> Ngày mua: {{ formatDate(order.created_at) }}
                            </q-item-label>
                        </q-item-section>

                        <q-item-section side>
                            <q-chip :color="order.product?.status === 1 ? 'positive' : 'warning'"
                                :label="order.product?.status === 1 ? 'Hoàn thành' : 'Đang xử lý'" />
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
const route = useRoute();
const title = ref('');
switch (route.params.type) {
    case '1':
        title.value = 'Đơn Đến';
        break;
    case '2':
        title.value = 'Đơn Đi';
        break;
    case '3':
        title.value = 'Lịch Sử Mua Hàng';
        break;
    default:
        title.value = 'Lịch Sử Mua Hàng';
        break;
}


const orders = ref([])

const formatDate = (dateString) => {
    return format(new Date(dateString), 'dd/MM/yyyy HH:mm');
}

const formatPrice = (price) => {
    return new Intl.NumberFormat('vi-VN').format(price);
}

const fetchBill = async () => {
    const temporaryToken = localStorage.getItem('token');
    const type = route.params.type;
    try {
        const response = await fetch(`https://phuctph.name.vn/api/bills/${type}`, {
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
        orders.value = data;
    } catch (error) {
        console.error('Error fetching bills:', error);
    }
};



onMounted(() => {
    fetchBill();
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