<template>
  <MainBanner />
  <MainCategory v-model="category" />
  <MainProduct />
</template>

<script setup>
import { ref } from 'vue';
import MainBanner from 'src/components/MainBanner.vue';
import MainCategory from 'src/components/MainCategory.vue';
import MainProduct from 'src/components/MainProduct.vue';

const category = ref([
  { name: 'Hộp bút', icon: 'home_repair_service' },
  { name: 'Vở', icon: 'menu_book' },
  { name: 'Bút', icon: 'edit' },
  { name: 'Cặp', icon: 'work' }
]);

defineOptions({
  name: 'IndexPage'
});
</script>
