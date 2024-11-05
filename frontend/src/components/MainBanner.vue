<template>
    <q-carousel animated v-model="slide" infinite :autoplay="autoplay" height="150px">
        <q-carousel-slide :name="1" img-src="/images/slide/slider-1.jpg" />
        <q-carousel-slide :name="2" img-src="/images/slide/slider-2.png" />
    </q-carousel>

</template>

<script setup>
import { ref } from 'vue'
const slide = ref(0)
const autoplay = ref(true)

defineOptions({
    name: 'MainBanner'
})
</script>