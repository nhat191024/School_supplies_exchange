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
                            <q-btn v-if="route.params.type === '4' && !order.review" label="Đánh giá" color="primary"
                                class="q-mt-sm" @click="openReviewModal(order)" />
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card-section>

            <!-- Review Modal -->
            <q-dialog v-model="isReviewModalOpen">
                <q-card class="review-modal">
                    <q-card-section>
                        <div class="text-h6">Đánh giá sản phẩm</div>
                    </q-card-section>
                    <q-card-section>
                        <q-input v-model="reviewForm.rating" type="number" label="Đánh giá (1-5)" min="1" max="5" />
                        <q-input v-model="reviewForm.comment" type="textarea" label="Nhận xét" />
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Hủy" color="negative" @click="closeReviewModal" />
                        <q-btn flat label="Gửi" color="primary" @click="submitReview" />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </q-card>
    </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { format } from 'date-fns';
import { useRoute } from 'vue-router';
import { useQuasar } from 'quasar';

const $q = useQuasar();
const route = useRoute();
const title = ref('');
const api = ref('https://school-supplies-exchange.taiyo.space/api/');
const temporaryToken = $q.localStorage.getItem('token');

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
    case '4':
        title.value = 'Đánh giá';
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
    const type = route.params.type;
    try {
        const response = await fetch(`${api.value}bills/${type}`, {
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

const isReviewModalOpen = ref(false);
const reviewForm = ref({
    bill_id: null,
    product_id: null,
    seller_id: null,
    rating: null,
    comment: '',
});

const openReviewModal = (order) => {
    reviewForm.value = {
        bill_id: order.id,
        product_id: order.product.id,
        seller_id: order.seller.id,
        rating: null,
        comment: '',
    };
    isReviewModalOpen.value = true;
};

const closeReviewModal = () => {
    isReviewModalOpen.value = false;
};

const submitReview = async () => {
    try {
        const response = await fetch(`${api.value}reviews`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${temporaryToken}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                bill_id: reviewForm.value.bill_id,
                product_id: reviewForm.value.product_id,
                seller_id: reviewForm.value.seller_id,
                rating: reviewForm.value.rating,
                comment: reviewForm.value.comment,
            }),
        });
        if (!response.ok) {
            const errorData = await response.text();
            console.error('Error:', errorData);
            throw new Error('Network response was not ok');
        } else {
            const data = await response.json();
            console.log('Review submitted successfully:', data);
        }

        isReviewModalOpen.value = false;
        fetchBill();
    } catch (error) {
        console.error('Error submitting review:', error);
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

.review-modal {
    max-width: 600px;
    /* Adjust the width as needed */
    width: 100%;
}
</style>