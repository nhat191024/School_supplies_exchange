<template>
    <q-page class="add-product-page">
        <p class="page-title">Sửa Sản Phẩm</p>
        <q-form @submit.prevent="submitProductForm">
            <q-input filled v-model="product.name" label="Tên sản phẩm" required />
            <q-select filled v-model="product.category" :options="categories" option-value="value" option-label="label"
                label="Danh mục" required />
            <q-input filled v-model="product.purchaseDate" type="date" label="Ngày mua" required />

            <q-select filled v-model="product.condition" :options="conditions" option-value="value" option-label="label"
                label="Tình trạng" required />

            <q-input filled v-model="product.purchasePrice" type="number" label="Giá" required />
            <q-input filled v-model="product.description" type="textarea" label="Mô tả" required />

            <q-select filled v-model="product.status" :options="status" option-value="value" option-label="label"
                label="Trạng thái" required style="margin-top: 20px;" />

            <q-file filled v-model="product.image" label="Ảnh sản phẩm" accept="image/*" style="margin-top: 20px;">
                <template v-slot:prepend>
                    <q-icon name="attach_file" />
                </template>
            </q-file>
            <q-btn type="submit" label="Sửa sản phẩm" color="primary" style="margin-top: 20px;" />
        </q-form>
    </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useQuasar } from 'quasar';

const router = useRouter();
const route = useRoute();
const $q = useQuasar();
const user_id = localStorage.getItem('id');

const product = ref({
    id: '',
    category: '',
    name: '',
    purchaseDate: '',
    condition: '',
    purchasePrice: '',
    description: '',
    status: '',
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

const status = ref([
    { label: 'Hiện', value: '1' },
    { label: 'Ẩn', value: '0' }
])

const api = "https://school-supplies-exchange.taiyo.space/api/products";

const fetchProduct = async (id) => {
    try {
        const response = await fetch(`${api}/${id}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        product.value = {
            id: data.id,
            category: categories.value.find(cat => cat.value == data.category_id) || '',
            name: data.name,
            purchaseDate: data.purchase_date,
            condition: conditions.value.find(cond => cond.value == data.condition) || '',
            purchasePrice: data.price,
            description: data.description,
            status: status.value.find(stat => stat.value == data.status) || '',
            image: null
        };
    } catch (error) {
        console.error('Error fetching product:', error);
    }
};

const submitProductForm = async () => {
    const formData = new FormData();
    formData.append('category_id', product.value.category.value);
    formData.append('user_id', user_id);
    formData.append('name', product.value.name);
    formData.append('purchase_date', product.value.purchaseDate);
    formData.append('condition', product.value.condition.value);
    formData.append('price', product.value.purchasePrice);
    formData.append('description', product.value.description);
    formData.append('status', product.value.status.value);

    if (product.value.image instanceof File) {
        formData.append('image', product.value.image);
    }

    try {
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        const response = await fetch(`${api}/update/${product.value.id}`, {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            const errorData = await response.text();
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log(data);

        $q.notify({
            type: 'positive',
            badgePosition: top,
            Animation: 'fadeIn',
            message: 'Sản phẩm đã được sửa thành công',
            timeout: 2000
        });
    } catch (error) {
        console.error('Error adding product:', error);
        $q.notify({
            type: 'negative',
            message: 'Có lỗi xảy ra khi sửa sản phẩm.',
            timeout: 2000
        });
    }
};

onMounted(async () => {
    const productId = route.params.id;
    await fetchProduct(productId);
});
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
