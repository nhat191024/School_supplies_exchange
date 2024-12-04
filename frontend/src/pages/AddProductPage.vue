<template>
    <q-page class="add-product-page">
        <p class="page-title">Thêm Sản Phẩm Mới</p>
        <q-form @submit.prevent="submitForm">
            <q-input filled v-model="product.name" label="Tên sản phẩm" required />
            <q-select filled v-model="product.category" :options="categories" option-value="value" option-label="label"
                label="Danh mục" required />
            <q-input filled v-model="product.purchaseDate" type="date" label="Ngày mua" required />
            <q-select filled v-model="product.condition" :options="conditions" option-value="value" option-label="label"
                label="Tình trạng" required />
            <q-input filled v-model="product.purchasePrice" type="number" label="Giá mua vào" required />
            <q-input filled v-model="product.description" type="textarea" label="Mô tả" required />
            <q-btn type="submit" label="Thêm sản phẩm" color="primary" style="margin-top: 20px;" />
        </q-form>
    </q-page>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const user_id = localStorage.getItem('id');

const product = ref({
    category: '',
    name: '',
    purchaseDate: '',
    condition: '',
    purchasePrice: '',
    description: ''
});

const categories = ref([
    { label: 'Books', value: '1' },
    { label: 'Stationery', value: '2' },
    { label: 'Notebooks', value: '3' },
    { label: 'Backpacks', value: '4' },
    { label: 'Art Supplies', value: '5' }
]);

const conditions = ref([
    { label: 'Mới', value: '1' },
    { label: 'Cũ', value: '0' }
]);

const api = "https://phuctph.name.vn/api/products";
const submitForm = async () => {

    const buyer_id = localStorage.getItem('id');
    if (!buyer_id || buyer_id == null) {
        alert('Vui lòng đăng nhập để đăng sản phẩm');
        return router.push('/profile');
    }

    const productData = {
        category_id: product.value.category.value,
        user_id: user_id,
        name: product.value.name,
        purchase_date: product.value.purchaseDate,
        condition: product.value.condition.value,
        price: product.value.purchasePrice,
        description: product.value.description,
        status: "1",
    };
    try {
        const response = await fetch(api, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(productData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Product added:', data);
    } catch (error) {
        console.error('Error adding product:', error);
        console.log('Product data:', productData);
    }
};
</script>

<style scoped>
.add-product-page {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.q-input,
.q-select,
.q-btn {
    margin-bottom: 15px;
}

.q-btn {
    width: 100%;
}
</style>
