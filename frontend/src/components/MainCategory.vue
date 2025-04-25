<template>
    <div class="category-container">
        <div class="category-item">
            <q-btn push color="red-10" class="q-py-sm" @click="navigateToCategory(null)">
                <div class="row items-center no-wrap">
                    <div style="text-wrap: nowrap;">Home</div>
                </div>
            </q-btn>
        </div>
        <div class="category-item" v-for="(cat, index) in modelValue" :key="index">
            <q-btn push color="red-10" class="q-py-sm" @click="navigateToCategory(cat.id)">
                <div class="row items-center no-wrap">
                    <div style="text-wrap: nowrap;">{{ cat.name }}</div>
                </div>
            </q-btn>
        </div>
    </div>
</template>

<script setup>
import { toRefs } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue']);
const { modelValue } = toRefs(props);

const router = useRouter();

function navigateToCategory(categoryId) {
    router.push({ path: `/categoryId`, query: { category: categoryId } });
}

defineOptions({
    name: 'MainCategory'
});
</script>