<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const products = ref([])

const perPage = ref(6)

const currentPage = ref(1)
const lastPage = ref(1)

const search = ref('')
const sortBy = ref('latest')

const loading = ref(false)

/*
|--------------------------------------------------------------------------
| Get Products
|--------------------------------------------------------------------------
*/

const getProducts = async (page = 1) => {

    try {

        loading.value = true

        const response = await axios.get('/api/products', {
            params: {
                page: page,
                per_page: perPage.value,
                search: search.value,
                sort_by: sortBy.value
            }
        })

        products.value = response.data.data

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

    if (
        page < 1 ||
        page > lastPage.value
    ) return

    getProducts(page)
}

/*
|--------------------------------------------------------------------------
| Edit Product
|--------------------------------------------------------------------------
*/

const editProduct = (product) => {

    router.push(
        `/products/${product.id}`
    )
}

/*
|--------------------------------------------------------------------------
| Delete Product
|--------------------------------------------------------------------------
*/

const deleteProduct = (product) => {

    if (
        confirm(`Bạn có chắc muốn xóa sản phẩm "${product.name}"?`)
    ) {

        axios.delete(`/api/products/${product.id}`)
            .then((response) => {

                alert(response.data.message)

                getProducts(currentPage.value)

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

    getProducts()
})

onMounted(() => {

    getProducts()
})
</script>

<template>
    <div class="layout">

        <main class="main-content">

            <section class="content">

                <!-- Header -->
                <div class="header">

                    <h2 class="title">
                        Quản lý sản phẩm
                    </h2>

                    <div class="actions">

                        <!-- Search -->
                        <input v-model="search" type="text" placeholder="Tìm sản phẩm..." class="search-input">

                        <!-- Per Page -->
                        <select v-model="perPage" class="sort-select">
                            <option :value="10">
                                10
                            </option>

                            <option :value="20">
                                20
                            </option>

                            <option :value="50">
                                50
                            </option>
                        </select>

                        <!-- Sort -->
                        <select v-model="sortBy" class="sort-select">
                            <option value="latest">
                                Mới nhất
                            </option>

                            <option value="name_asc">
                                Tên A-Z
                            </option>

                            <option value="name_desc">
                                Tên Z-A
                            </option>

                            <option value="price_asc">
                                Giá tăng dần
                            </option>

                            <option value="price_desc">
                                Giá giảm dần
                            </option>
                        </select>

                    </div>

                </div>

                <!-- Loading -->
                <div v-if="loading" class="loading">
                    Đang tải dữ liệu...
                </div>

                <!-- Products -->
                <div v-else class="product-grid">

                    <div class="product-card" v-for="product in products" :key="product.id">

                        <!-- Image -->
                        <img :src="'/layout/images/products/' + product.image" :alt="product.name"
                            class="product-image">

                        <!-- Body -->
                        <div class="product-body">

                            <div class="top">

                                <h3>
                                    {{ product.name }}
                                </h3>

                                <span class="status">
                                    {{
                                        product.status
                                            ? 'Hoạt động'
                                            : 'Ẩn'
                                    }}
                                </span>

                            </div>

                            <p class="category">
                                {{ product.category.name }}
                            </p>

                            <p class="description">
                                {{ product.description }}
                            </p>

                            <div class="meta">

                                <span>
                                    Kho:
                                    {{ product.stock }}
                                </span>

                            </div>

                            <div class="bottom">

                                <p class="price">
                                    {{
                                        Number(product.price)
                                            .toLocaleString()
                                    }} đ
                                </p>

                                <div class="actions-btn">

                                    <button class="edit-btn" @click="editProduct(product)">
                                        Edit
                                    </button>

                                    <button class="delete-btn" @click="deleteProduct(product)">
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

                    <button v-for="page in lastPage" :key="page" @click="changePage(page)" :class="{
                        active: currentPage === page
                    }">
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

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 20px;
}

.title {
    color: #1e293b;
    font-size: 28px;
}

.actions {
    display: flex;
    gap: 12px;
}

.search-input,
.sort-select {
    padding: 12px 30px 12px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    outline: none;
    font-size: 14px;
}

.search-input {
    width: 250px;
}

.loading {
    text-align: center;
    padding: 50px;
    font-size: 18px;
}

/* Products */
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.product-card {
    background: white;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    transition: 0.3s;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.product-image {
    padding: 12px;
    width: 100%;
    height: 280px;
    object-fit: cover;
}

.product-body {
    padding: 18px;
}

.top {
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 10px;
    margin-bottom: 10px;
}

.top h3 {
    font-size: 18px;
    color: #1e293b;
    line-height: 1.4;
}

.status {
    background: #dcfce7;
    color: #166534;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    white-space: nowrap;
}

.category {
    color: #64748b;
    margin-bottom: 10px;
    font-size: 14px;
}

.description {
    color: #475569;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 14px;

    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;

    overflow: hidden;
}

.meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 18px;
    color: #475569;
    font-size: 14px;
}

.bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.price {
    font-size: 22px;
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
    font-size: 14px;
    transition: 0.3s;
}

.edit-btn {
    background: #2563eb;
    color: white;
}

.edit-btn:hover {
    background: #1d4ed8;
}

.delete-btn {
    background: #ef4444;
    color: white;
}

.delete-btn:hover {
    background: #dc2626;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 35px;
    flex-wrap: wrap;
}

.pagination button {
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    background: #e2e8f0;
    cursor: pointer;
    transition: 0.3s;
}

.pagination button:hover {
    background: #cbd5e1;
}

.pagination button.active {
    background: #3b82f6;
    color: white;
}

.pagination button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>