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

            </nav>

        </aside>

        <!-- Content -->
        <main class="content">
            <router-view />
        </main>

    </div>
</template>

<script setup>
import { ref } from 'vue'

const isCollapsed = ref(false)
const showProductMenu = ref(true)
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

.sidebar {
    width: 260px;
    background: linear-gradient(180deg, #111827, #1f2937);
    color: white;
    transition: all .3s ease;
    overflow: hidden;
    box-shadow: 4px 0 20px rgba(0, 0, 0, .15);
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
</style>