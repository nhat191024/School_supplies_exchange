<template>
  <MainBanner />
  <MainCategory v-model="category" />
  <MainProduct />
</template>

<script setup>
import { ref, onMounted } from 'vue';
import MainBanner from 'src/components/MainBanner.vue';
import MainCategory from 'src/components/MainCategory.vue';
import MainProduct from 'src/components/MainProduct.vue';

const category = ref([
  { name: 'Tất cả', icon: 'home', id: 0 },
  { name: 'Hộp bút', icon: 'home_repair_service', id: 1 },
  { name: 'Vở', icon: 'menu_book' },
  { name: 'Bút', icon: 'edit' },
  { name: 'Cặp', icon: 'work' }
]);

onMounted(() => {
  fetch('http://192.168.1.4:8000/api/categories')
    .then(response => response.json())
    .then(data => {
      category.value = data;
    })
    .catch(error => console.error('Error fetching categories:', error));
});

defineOptions({
  name: 'IndexPage'
});
</script>
