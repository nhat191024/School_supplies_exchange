<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar class="bg-red-10 text-white shadow-2">
        <q-input bg-color="white" color="red" outlined rounded standout v-model="text" placeholder="Placeholder"
          class="q-my-sm">
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>

        <q-space />

        <q-icon name="notifications" size="2rem" />
        <q-space />
        <q-icon name="forum" size="1.7rem" />

      </q-toolbar>
    </q-header>

    <q-footer class="bg-red-10 footer" :elevated="true" :class="{ 'q-footer--fixed': true }">
      <q-tabs v-model="tab" dense class="text-white footer-tab-container" justify="between">
        <q-tab name="home" icon="home" label="Trang chủ" @click="goTo('home')" />
        <q-tab name="post" icon="edit_square" label="Đăng bài" class="footer-tab-post-btn" @click="goTo('post')" />
        <q-tab name="user" icon="account_circle" label="Tài khoản" @click="goTo('profile')" />
      </q-tabs>
    </q-footer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const tab = ref('home')
const router = useRouter()

function goTo(tabName) {
  switch (tabName) {
    case 'home':
      router.push('/')
      break
    case 'post':
      router.push('/post-product')
      break
    case 'profile':
      router.push('/profile')
      break
  }
}

defineOptions({
  name: 'MainLayout'
})
</script>