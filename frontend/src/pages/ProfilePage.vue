<template>
    <div v-if="isLogin" class="user-profile">
        <div class="profile-header">
            <q-avatar size="100px" class="profile-avatar">
                <img src="/images/hajime.jpg" alt="User Avatar" />
            </q-avatar>
            <div class="profile-info">
                <h4>{{ name }}</h4>
                <div class="rating">
                    <q-rating v-model="rating" readonly :max="5" size="20px" />
                    <span>(0)</span>
                </div>
                <div class="followers">
                    <span>{{ followers }} Người theo dõi</span> |
                    <span>{{ following }} Đang theo dõi</span>
                </div>
            </div>
        </div>
        <div class="order-management">
            <p class="item-title">Quản lí đơn</p>
            <q-list bordered class="list">
                <q-item clickable @click="goToHistory(1)">
                    <q-item-section>Đơn đến</q-item-section>
                </q-item>
                <q-item clickable @click="goToHistory(2)">
                    <q-item-section>Đơn đi</q-item-section>
                </q-item>
                <q-item clickable @click="goToHistory(3)">
                    <q-item-section>Lịch sử</q-item-section>
                </q-item>
            </q-list>
        </div>
        <div class="utilities">
            <p class="item-title">Tiện ích</p>
            <q-list bordered class="list">
                <q-item clickable>
                    <q-item-section>Tin đã đăng</q-item-section>
                </q-item>
                <q-item clickable>
                    <q-item-section>Hàng đã lưu</q-item-section>
                </q-item>
                <q-item clickable>
                    <q-item-section>Đánh giá</q-item-section>
                </q-item>
            </q-list>
        </div>
        <div class="utilities">
            <p class="item-title">Tài khoản</p>
            <q-list bordered class="list">
                <q-item clickable @click="logout">
                    <q-item-section>Đăng xuất</q-item-section>
                </q-item>
            </q-list>
        </div>
    </div>

    <div v-else class="login-form">
        <h5>Đăng nhập</h5>
        <q-form @submit.prevent="onLogin" class="form-content">
            <q-input v-model="username" label="Username" outlined class="input" />
            <q-input v-model="password" label="Password" type="password" outlined class="input" />
            <q-btn type="submit" label="Login" color="primary" />
        </q-form>
        <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const rating = ref(0);
const followers = ref(0);
const following = ref(0);
const name = ref('');

const username = ref('');
const password = ref('');
const errorMessage = ref('');
const isLogin = ref(true);

async function onLogin() {
    errorMessage.value = '';
    try {
        const response = await fetch('https://phuctph.name.vn/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: username.value,
                password: password.value,
            }),
        });

        const data = await response.json();
        if (!response.ok) {
            const errorData = await response.text();
            console.error('Error:', errorData);
            errorMessage.value = errorData;
            throw new Error(errorData);
        } else {
            isLogin.value = true;
            localStorage.setItem('token', data.access_token);
            getProfile();
        }
    } catch (error) {
        console.error('Error:', error);
        errorMessage.value = "sai tên đăng nhập hoặc mật khẩu";
    }
};

async function getProfile() {
    const temporaryToken = localStorage.getItem('token');
    try {
        const response = await fetch('https://phuctph.name.vn/api/me', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${temporaryToken}`
            },
        });

        const data = await response.json();
        if (!response.ok) {
            const errorData = await response.text();
            console.error('Error:', errorData);
            errorMessage.value = errorData;
            throw new Error(errorData);
        } else {
            name.value = data.name;
            localStorage.setItem('id', data.id);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('id');3
    isLogin.value = false;
}

function checkTokenInLocalStorage() {
    const token = localStorage.getItem('token');
    if (token == "undefined" || token == null) {
        console.log('not login');
        isLogin.value = false;
    } else {
        getProfile();
        isLogin.value = true;
    }
}

checkTokenInLocalStorage();

const goToHistory = (type) => {
    router.push('/history/' + type);
};
</script>
<style scoped>
.list {
    border-radius: 16px;
}

.item-title {
    font-size: 20px;
    font-weight: 600;
    margin: 16px 0;
}

.user-profile {
    padding: 16px;
}

.profile-header {
    display: flex;
    align-items: center;
}

.profile-avatar {
    margin-right: 16px;
}

.profile-info h4 {
    margin: 0;
}

.rating {
    display: flex;
    align-items: center;
}

.followers {
    font-size: 14px;
    color: #888;
}

.profile-stats {
    margin-top: 16px;
}

.stats {
    display: flex;
    justify-content: space-between;
}

.login-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 100px;
}

.input,
.form-content q-btn {
    margin-bottom: 16px;
}

.error-message {
    color: red;
    margin-top: 16px;
}
</style>