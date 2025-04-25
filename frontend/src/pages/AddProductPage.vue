<template>
    <q-page class="add-product-page">
        <p class="page-title">Thêm Sản Phẩm Mới</p>
        <q-form @submit.prevent="submitProductForm">
            <q-input filled v-model="product.name" label="Tên sản phẩm" required />
            <q-select filled v-model="product.category" :options="categories" option-value="value" option-label="label"
                label="Danh mục" required />
            <q-input filled v-model="product.purchaseDate" type="date" label="Ngày mua" required />
            <q-select filled v-model="product.condition" :options="conditions" option-value="value" option-label="label"
                label="Tình trạng" required />
            <q-input filled v-model="product.purchasePrice" type="number" label="Giá mua vào" required />
            <q-input filled v-model="product.description" type="textarea" label="Mô tả" required />
            <q-file filled v-model="product.image" label="Ảnh sản phẩm" accept="image/*" style="margin-top: 20px;">
                <template v-slot:prepend>
                    <q-icon name="attach_file" />
                </template>
            </q-file>
            <q-btn type="submit" label="Thêm sản phẩm" color="primary" style="margin-top: 20px;" />
        </q-form>
    </q-page>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useQuasar } from 'quasar';

const router = useRouter();
const $q = useQuasar();
const user_id = localStorage.getItem('id');

const product = ref({
    category: '',
    name: '',
    purchaseDate: '',
    condition: '',
    purchasePrice: '',
    description: '',
    image: null
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

const api = "https://school-supplies-exchange.taiyo.space/api/products";
const submitProductForm = async () => {
    const buyer_id = localStorage.getItem('id');
    if (!buyer_id || buyer_id == null) {
        alert('Vui lòng đăng nhập để đăng sản phẩm');
        return router.push('/profile');
    }

    const formData = new FormData();
    formData.append('category_id', product.value.category.value);
    formData.append('user_id', user_id);
    formData.append('name', product.value.name);
    formData.append('purchase_date', product.value.purchaseDate);
    formData.append('condition', product.value.condition.value);
    formData.append('price', product.value.purchasePrice);
    formData.append('description', product.value.description);
    formData.append('status', "1");

    if (product.value.image instanceof File) {
        formData.append('image', product.value.image);
    }

    try {
        console.log(formData);
        const response = await fetch(api, {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log('Product added:', data);

        // Show success notification using $q.notify
        $q.notify({
            type: 'positive',
            'badgePosition': 'top',
            message: 'Sản phẩm đã được thêm thành công!',
            timeout: 2000
        });

        // Reset form
        product.value = {
            category: '',
            name: '',
            purchaseDate: '',
            condition: '',
            purchasePrice: '',
            description: '',
            image: null
        };
    } catch (error) {
        console.error('Error adding product:', error);
        // Optionally add error notification
        $q.notify({
            type: 'negative',
            message: 'Có lỗi xảy ra khi thêm sản phẩm.',
            timeout: 2000
        });
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
