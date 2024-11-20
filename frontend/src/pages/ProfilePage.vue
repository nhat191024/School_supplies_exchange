<template>
    <div class="user-profile">
        <div class="profile-header">
            <q-avatar size="100px" class="profile-avatar">
                <img src="/images/hajime.jpg" alt="User Avatar" />
            </q-avatar>
            <div class="profile-info">
                <h4>Pham Do Thanh Lam</h4>
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
                <q-item clickable>
                    <q-item-section>Đơn đến</q-item-section>
                </q-item>
                <q-item clickable>
                    <q-item-section>Đơn đi</q-item-section>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            rating: 0,
            followers: 0,
            following: 0,
        };
    },
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
</style>