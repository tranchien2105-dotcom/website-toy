<template>
    <div class="layout">

        <!-- Sidebar -->
        <aside class="sidebar" :class="{ collapsed: isCollapsed }">

            <div class="sidebar-header">
                <h2 v-if="!isCollapsed">Dashboard</h2>

                <button class="toggle-btn" @click="isCollapsed = !isCollapsed">
                    ☰
                </button>
            </div>

            <nav>
                <router-link to="/home">
                    🏠 <span v-if="!isCollapsed">Home</span>
                </router-link>

                <!-- Products -->
                <div class="menu-group">

                    <div class="menu-title" @click="showProductMenu = !showProductMenu">
                        <span>📦</span>

                        <span v-if="!isCollapsed" class="title">
                            Products
                        </span>

                        <span v-if="!isCollapsed" class="arrow" :class="{ rotate: showProductMenu }">
                            ▼
                        </span>
                    </div>

                    <div v-if="showProductMenu && !isCollapsed" class="submenu">
                        <router-link to="/products">
                            📋 All Products
                        </router-link>

                        <router-link to="/products/create">
                            ➕ Create Product
                        </router-link>


                    </div>

                </div>

                <router-link to="/banners">
                    🖼️ <span v-if="!isCollapsed">Banners</span>
                </router-link>

                <router-link to="/orders">
                    📄 <span v-if="!isCollapsed">Orders</span>
                </router-link>

                <router-link to="/categories">
                    🗂️ <span v-if="!isCollapsed">Categories</span>
                </router-link>

                <router-link to="/blogs">
                    📝 <span v-if="!isCollapsed">Blogs</span>
                </router-link>


            </nav>

            <div v-if="user" class="user-info" @click="showUserMenu = !showUserMenu">
                <div class="avatar">
                    {{ user?.name?.charAt(0).toUpperCase() }}
                </div>

                <div v-if="!isCollapsed" class="user-detail">
                    <div class="name">
                        {{ user.name }}
                    </div>

                    <div class="email">
                        {{ user.email }}
                    </div>
                </div>

                <span v-if="!isCollapsed" class="user-arrow">
                    ▼
                </span>

                <div v-if="showUserMenu && !isCollapsed" class="user-dropdown">
                    <button @click.stop="logout">
                        🚪 Đăng xuất
                    </button>
                </div>
            </div>



        </aside>

        <!-- Content -->
        <main class="content">
            <router-view />
        </main>

    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const showUserMenu = ref(false)
const isCollapsed = ref(false)
const showProductMenu = ref(true)
const router = useRouter()
const user = ref(null)
const getProfile = async () => {
    try {
        const { data } = await axios.get('/api/profile')

        user.value = data.user
    } catch (error) {
        console.error(error)
    }
}

const logout = async () => {
    try {
        await axios.post('/api/logout')
    } catch (error) {
        console.log(error)
    } finally {
        localStorage.removeItem('token')
        router.push('/admin/login')
    }
}

onMounted(() => {
    getProfile()
})
</script>

<style lang="css" scoped>
.layout {
    display: flex;
    min-height: 100vh;
    background: #f3f4f6;
    font-family: Inter, sans-serif;
}

/* ==========================
        SIDEBAR
========================== */
.logout-box {
    padding: 16px;
    border-top: 1px solid rgba(255, 255, 255, .08);
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px 16px;
    background: transparent;
    border: none;
    border-radius: 12px;
    color: #f87171;
    cursor: pointer;
    font-size: 15px;
    font-weight: 500;
    transition: .25s;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, .15);
    color: white;
}

.sidebar.collapsed .logout-btn {
    justify-content: center;
    padding: 15px;
}

.sidebar.collapsed .logout-btn span {
    display: none;
}

.sidebar {
    width: 260px;
    background: linear-gradient(180deg, #111827, #1f2937);
    color: white;
    transition: all .3s ease;
    overflow: hidden;

    display: flex;
    flex-direction: column;
}

.sidebar.collapsed {
    width: 80px;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 22px;
    border-bottom: 1px solid rgba(255, 255, 255, .08);
}

.sidebar-header h2 {
    color: #60a5fa;
    font-size: 22px;
    font-weight: bold;
}

.toggle-btn {
    width: 38px;
    height: 38px;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, .08);
    color: white;
    cursor: pointer;
    font-size: 18px;
    transition: .25s;
}

.toggle-btn:hover {
    background: #3b82f6;
    transform: rotate(90deg);
}

.sidebar nav {
    flex: 1;
    padding: 20px 12px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 15px;

    padding: 14px 16px;
    border-radius: 12px;

    text-decoration: none;
    color: #d1d5db;

    transition: .25s;
    white-space: nowrap;
    font-weight: 500;
}

.sidebar a:hover {
    background: rgba(59, 130, 246, .15);
    color: white;
    transform: translateX(5px);
}

.router-link-active {
    background: #2563eb;
    color: white !important;
    box-shadow: 0 8px 20px rgba(37, 99, 235, .35);
}

/* Thu gọn */

.sidebar.collapsed a {
    justify-content: center;
    padding: 15px;
}

.sidebar.collapsed a span {
    display: none;
}

.sidebar.collapsed .sidebar-header {
    justify-content: center;
}

.sidebar.collapsed h2 {
    display: none;
}

/* ==========================
        CONTENT
========================== */

.content {
    flex: 1;
    padding: 30px;
}

.content>* {
    background: white;
    border-radius: 18px;
    padding: 24px;
    min-height: calc(100vh - 60px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
}

/* ==========================
        MOBILE
========================== */

@media(max-width:768px) {

    .sidebar {
        position: fixed;
        z-index: 999;
        height: 100vh;
    }

    .sidebar.collapsed {
        transform: translateX(-100%);
        width: 260px;
    }

    .content {
        padding: 20px;
        margin-left: 0;
    }
}

.menu-group {
    display: flex;
    flex-direction: column;
}

.menu-title {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px 16px;
    border-radius: 12px;
    color: #d1d5db;
    cursor: pointer;
    transition: .25s;
}

.menu-title:hover {
    background: rgba(59, 130, 246, .15);
    color: white;
}

.title {
    flex: 1;
}

.arrow {
    font-size: 12px;
    transition: .25s;
}

.arrow.rotate {
    transform: rotate(180deg);
}

.submenu {
    margin-left: 22px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding-top: 6px;
}

.submenu a {
    padding: 10px 14px;
    font-size: 14px;
    border-radius: 10px;
    color: #9ca3af;
}

.submenu a:hover {
    background: rgba(255, 255, 255, .06);
    color: white;
}

.user-info {
    position: relative;
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px;
    border-top: 1px solid rgba(255, 255, 255, .08);
    cursor: pointer;
}

.user-info:hover {
    background: rgba(255, 255, 255, .04);
}

.user-arrow {
    margin-left: auto;
    font-size: 12px;
    color: #9ca3af;
}

.user-dropdown {
    position: absolute;
    left: 15px;
    right: 15px;
    bottom: 78px;

    background: #1f2937;
    border: 1px solid rgba(255, 255, 255, .08);
    border-radius: 12px;
    overflow: hidden;

    box-shadow: 0 10px 25px rgba(0, 0, 0, .3);
    z-index: 999;
}

.user-dropdown button {
    width: 100%;
    border: none;
    background: transparent;
    color: white;
    padding: 14px 16px;
    text-align: left;
    cursor: pointer;
    transition: .25s;
}

.user-dropdown button:hover {
    background: rgba(239, 68, 68, .15);
    color: #f87171;
}

.avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 18px;
}

.user-detail {
    overflow: hidden;
}

.name {
    color: white;
    font-weight: 600;
}

.email {
    color: #9ca3af;
    font-size: 13px;
}

.sidebar.collapsed .user-detail {
    display: none;
}

.sidebar.collapsed .user-info {
    justify-content: center;
}
</style>