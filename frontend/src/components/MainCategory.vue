<template>
    <div class="category-container">
        <div class="category-item" v-for="(cat, index) in modelValue" :key="index">
            <!-- <div class="category-btn">
                <q-icon :name="cat.icon" class="q-mr-sm" />
                <span>{{ cat.name }}</span>
            </div> -->
            <q-btn push color="red-10" class="q-py-sm">
                <div class="row items-center no-wrap">
                    <q-icon size="2em" :name="cat.icon" class="q-mr-sm" />
                    <div style="text-wrap: nowrap;">{{ cat.name }}</div>
                </div>
            </q-btn>
        </div>
    </div>
</template>

<script setup>
import { toRefs } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue']);
const { modelValue } = toRefs(props);

defineOptions({
    name: 'MainCategory'
})
</script>