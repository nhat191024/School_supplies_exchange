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
                    <q-item-section clickable @click="goToPostedProducts()">Sản phẩm đã đăng</q-item-section>
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

    <div v-else class="auth-forms">
        <div v-if="showLoginForm" class="login-form">
            <h5>Đăng nhập</h5>
            <q-form @submit.prevent="onLogin" class="form-content">
                <q-input v-model="username" label="Username" outlined class="input" />
                <q-input v-model="password" label="Password" type="password" outlined class="input" />
                <q-btn type="submit" label="Login" color="primary" />
            </q-form>
            <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>
            <q-btn flat @click="toggleForm">Đăng ký</q-btn>
        </div>
        <div v-else class="register-form">
            <h5>Đăng ký</h5>
            <q-form @submit.prevent="onRegister" class="form-content">
                <q-input v-model="registerName" label="Name" outlined class="input"
                    :rules="[val => !!val || 'Name is required', val => val.length <= 255 || 'Name must be less than 255 characters']" />
                <q-input v-model="registerEmail" label="Email" type="email" outlined class="input"
                    :rules="[val => !!val || 'Email is required', val => /.+@.+\..+/.test(val) || 'Email must be valid', val => val.length <= 255 || 'Email must be less than 255 characters']" />
                <q-input v-model="registerPassword" label="Password" type="password" outlined class="input"
                    :rules="[val => !!val || 'Password is required', val => val.length >= 8 || 'Password must be at least 8 characters']" />
                <q-input v-model="registerPasswordConfirmation" label="Confirm Password" type="password" outlined
                    class="input" :rules="confirmPasswordRules" />
                <q-input v-model="registerSchool" label="School" outlined class="input"
                    :rules="[val => val.length <= 255 || 'School must be less than 255 characters']" />
                <q-input v-model="registerAddress" label="Address" outlined class="input"
                    :rules="[val => val.length <= 255 || 'Address must be less than 255 characters']" />
                <q-input v-model="registerPhone" label="Phone" outlined class="input"
                    :rules="[val => val.length <= 15 || 'Phone must be less than 15 characters']" />
                <q-btn type="submit" label="Register" color="primary" />
            </q-form>
            <div v-if="registerErrorMessage" class="error-message">{{ registerErrorMessage }}</div>
            <q-btn flat @click="toggleForm">Đăng nhập</q-btn>
        </div>
    </div>

    <q-dialog v-model="showSuccessDialog">
        <q-card>
            <q-card-section>
                <div class="text-h6">Đăng ký thành công</div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="OK" color="primary" @click="onSuccessDialogOk" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const rating = ref(0);
const followers = ref(0);
const following = ref(0);
const name = ref('');

const username = ref('');
const password = ref('');
const errorMessage = ref('');
const isLogin = ref(false);

const registerName = ref('');
const registerEmail = ref('');
const registerPassword = ref('');
const registerPasswordConfirmation = ref('');
const registerSchool = ref('');
const registerAddress = ref('');
const registerPhone = ref('');
const registerErrorMessage = ref('');

const showLoginForm = ref(true);
const showSuccessDialog = ref(false);

const confirmPasswordRules = computed(() => [
    val => !!val || 'Confirm Password is required',
    val => val === registerPassword.value || 'Passwords must match'
]);

function toggleForm() {
    showLoginForm.value = !showLoginForm.value;
}

async function onLogin() {
    errorMessage.value = '';
    try {
        const response = await fetch('http://192.168.1.4:8000/api/login', {
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

async function onRegister() {
    registerErrorMessage.value = '';
    try {
        const response = await fetch('http://192.168.1.4:8000/api/users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: registerName.value,
                email: registerEmail.value,
                password: registerPassword.value,
                password_confirmation: registerPasswordConfirmation.value,
                school: registerSchool.value,
                address: registerAddress.value,
                phone: registerPhone.value,
                avatar: "avatars/alice.jpg",
                role: '0',
            }),
        });

        const data = await response.json();
        if (!response.ok) {
            const errorData = await response.text();
            console.error('Error:', errorData);
            registerErrorMessage.value = errorData;
            throw new Error(errorData);
        } else {
            showSuccessDialog.value = true;
        }
    } catch (error) {
        console.error('Error:', error);
        registerErrorMessage.value = "Đăng ký thất bại";
    }
}

async function getProfile() {
    const temporaryToken = localStorage.getItem('token');
    try {
        const response = await fetch('http://192.168.1.4:8000/api/me', {
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
    localStorage.removeItem('id'); 3
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

function onSuccessDialogOk() {
    showSuccessDialog.value = false;
    username.value = registerEmail.value;
    password.value = registerPassword.value;
    onLogin();
}

checkTokenInLocalStorage();

const goToHistory = (type) => {
    router.push('/history/' + type);
};

const goToPostedProducts = () => {
    router.push('/posted-products');
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

.auth-forms {
    display: flex;
    justify-content: space-around;
    margin-top: 100px;
}

.login-form,
.register-form {
    width: 45%;
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