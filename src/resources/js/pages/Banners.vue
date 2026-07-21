<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const banners = ref([])

const perPage = ref(5)
const currentPage = ref(1)
const lastPage = ref(1)

const search = ref('')
const sortBy = ref('latest')

const loading = ref(false)

/*
|--------------------------------------------------------------------------
| Get banners
|--------------------------------------------------------------------------
*/

const getBanners = async (page = 1) => {
    try {
        loading.value = true

        const response = await axios.get('/api/banners', {
            params: {
                page: page,
                per_page: perPage.value,
                search: search.value,
                sort_by: sortBy.value
            }
        })

        banners.value = response.data.data
        currentPage.value = response.data.current_page
        lastPage.value = response.data.last_page

    } catch (error) {
        console.error('Lỗi API:', error)
    } finally {
        loading.value = false
    }
}

/*
|--------------------------------------------------------------------------
| Change Page
|--------------------------------------------------------------------------
*/

const changePage = (page) => {
    if (page < 1 || page > lastPage.value) return
    getBanners(page)
}

/*
|--------------------------------------------------------------------------
| Edit Banner
|--------------------------------------------------------------------------
*/

const editBanner = (banner) => {
    router.push(`/banners/${banner.id}`)
}

/*
|--------------------------------------------------------------------------
| Add Banner
|--------------------------------------------------------------------------
*/

const addBanner = () => {
    router.push('/banners/create')
}

/*
|--------------------------------------------------------------------------
| Delete Banner
|--------------------------------------------------------------------------
*/

const deleteBanner = (banner) => {

    if (
        confirm(`Bạn có chắc muốn xóa banner "${banner.title}"?`)
    ) {
        axios.delete(`/api/banners/${banner.id}`)
            .then((response) => {

                alert(response.data.message)

                getBanners(currentPage.value)

            })
            .catch(error => {

                console.error('Lỗi API:', error)

                alert(error.response.data.message)
            })
    }
}

/*
|--------------------------------------------------------------------------
| Watch Filters
|--------------------------------------------------------------------------
*/

watch([search, sortBy, perPage], () => {
    getBanners()
})

onMounted(() => {
    getBanners()
})
</script>

<template>
    <div class="layout">

        <main class="main-content">

            <section class="content">

                <!-- Header -->
                <div class="header">

                    <div class="header-left">
                        <h2 class="title">
                            Quản lý Banner
                        </h2>
                    </div>

                    <div class="header-right">

                        <!-- Add -->
                        <button class="add-btn" @click="addBanner">
                            + Thêm Banner
                        </button>

                        <!-- Search -->
                        <input v-model="search" type="text" placeholder="Tìm banner..." class="search-input">

                        <!-- Per Page -->
                        <select v-model="perPage" class="sort-select">
                            <option :value="5">5</option>
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                        </select>

                        <!-- Sort -->
                        <select v-model="sortBy" class="sort-select">
                            <option value="latest">
                                Mới nhất
                            </option>

                            <option value="title_asc">
                                Tiêu đề A-Z
                            </option>

                            <option value="title_desc">
                                Tiêu đề Z-A
                            </option>

                            <option value="position_asc">
                                Position tăng dần
                            </option>
                        </select>

                    </div>

                </div>

                <!-- Loading -->
                <div v-if="loading" class="loading">
                    Đang tải dữ liệu...
                </div>

                <!-- Banner Grid -->
                <div v-else class="banner-grid">

                    <div class="banner-card" v-for="banner in banners" :key="banner.id">

                        <img :src="'/layout/images/banners/' + banner.image_url" :alt="banner.title"
                            class="banner-image">

                        <div class="banner-body">

                            <div class="top">

                                <h3>
                                    {{ banner.title }}
                                </h3>

                                <span class="status">
                                    {{
                                        banner.status
                                            ? 'Hoạt động'
                                            : 'Ẩn'
                                    }}
                                </span>

                            </div>

                            <p class="category">
                                Type: {{ banner.type }}
                            </p>

                            <p class="description">
                                {{ banner.description }}
                            </p>

                            <p class="date">
                                {{ banner.start_at || '---' }}
                                →
                                {{ banner.end_at || '---' }}
                            </p>

                            <div class="meta">

                                <span>
                                    Device: {{ banner.device }}
                                </span>

                                <span>
                                    Position: {{ banner.position }}
                                </span>

                            </div>

                            <div class="bottom">

                                <p class="price">
                                    Click: {{ banner.click_count }}
                                </p>

                                <div class="actions-btn">

                                    <button class="edit-btn" @click="editBanner(banner)">
                                        Edit
                                    </button>

                                    <button class="delete-btn" @click="deleteBanner(banner)">
                                        Xóa
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Pagination -->
                <div class="pagination">

                    <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
                        ← Trước
                    </button>

                    <button v-for="page in lastPage" :key="page" @click="changePage(page)"
                        :class="{ active: currentPage === page }">
                        {{ page }}
                    </button>

                    <button @click="changePage(currentPage + 1)" :disabled="currentPage === lastPage">
                        Sau →
                    </button>

                </div>

            </section>

        </main>

    </div>
</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

.layout {
    min-height: 100vh;
    background: #f4f7fb;
}

.main-content {
    padding: 24px;
}

.content {
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

/* HEADER */

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 20px;
}

.header-right {
    display: flex;
    gap: 12px;
    align-items: center;
}

.title {
    color: #1e293b;
    font-size: 28px;
}

/* ADD BUTTON */

.add-btn {
    border: none;
    background: #10b981;
    color: white;
    padding: 12px 18px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}

.add-btn:hover {
    background: #059669;
}

/* INPUTS */

.search-input,
.sort-select {
    padding: 12px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    outline: none;
    font-size: 14px;
}

.search-input {
    width: 250px;
}

/* LOADING */

.loading {
    text-align: center;
    padding: 50px;
    font-size: 18px;
}

/* GRID */

.banner-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.banner-card {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    transition: 0.3s;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.banner-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.banner-image {
    padding: 12px;
    width: 100%;
    height: 220px;
    object-fit: cover;
}

.banner-body {
    padding: 18px;
}

.top {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 10px;
}

.top h3 {
    font-size: 18px;
    color: #1e293b;
}

.status {
    background: #dcfce7;
    color: #166534;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
}

.category {
    color: #64748b;
    margin-bottom: 10px;
}

.description {
    font-size: 14px;
    margin-bottom: 10px;
    color: #475569;
}

.date {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 12px;
}

.meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 18px;
    font-size: 14px;
}

.bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 15px;
    font-weight: bold;
    color: #2563eb;
}

.actions-btn {
    display: flex;
    gap: 10px;
}

.edit-btn,
.delete-btn {
    border: none;
    padding: 10px 14px;
    border-radius: 10px;
    cursor: pointer;
}

.edit-btn {
    background: #2563eb;
    color: white;
}

.delete-btn {
    background: #ef4444;
    color: white;
}

/* PAGINATION */

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 35px;
}

.pagination button {
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    background: #e2e8f0;
    cursor: pointer;
}

.pagination button.active {
    background: #3b82f6;
    color: white;
}
</style>