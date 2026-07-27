<template>
    <div class="page-card">
        <div class="page-header">
            <div>
                <h1>Quản lý bình luận sản phẩm</h1>
                <p>Danh sách bình luận và trạng thái ẩn/hiện của admin</p>
            </div>
        </div>

        <div class="card-actions">
            <div class="filter-group">
                <select v-model="filters.product_id" class="select-input">
                    <option value="">-- Tất cả sản phẩm --</option>
                    <option v-for="product in products" :key="product.id" :value="product.id">
                        {{ product.name }}
                    </option>
                </select>

                <input
                    v-model="filters.keyword"
                    type="text"
                    placeholder="Tìm kiếm tên hoặc nội dung"
                    class="text-input"
                />

                <button class="btn btn-primary" @click="getComments()">Lọc</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!comments.length">
                        <td colspan="7" class="text-center">Chưa có bình luận.</td>
                    </tr>
                    <tr v-for="(comment, index) in comments" :key="comment.id">
                        <td>{{ (currentPage - 1) * perPage + index + 1 }}</td>
                        <td>{{ comment.product?.name || '-' }}</td>
                        <td>{{ comment.name || 'Khách' }}</td>
                        <td>{{ comment.email || '-' }}</td>
                        <td>{{ comment.comment }}</td>
                        <td>
                            <span :class="['badge', comment.is_hidden ? 'badge-secondary' : 'badge-success']">
                                {{ comment.is_hidden ? 'Hidden' : 'Visible' }}
                            </span>
                        </td>
                        <td>
                            <button
                                class="btn btn-sm"
                                :class="comment.is_hidden ? 'btn-success' : 'btn-warning'"
                                @click="toggleHidden(comment)"
                            >
                                {{ comment.is_hidden ? 'Hiện' : 'Ẩn' }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-box" v-if="lastPage > 1">
            <button class="page-btn" :disabled="currentPage === 1" @click="changePage(currentPage - 1)">Prev</button>
            <button
                class="page-btn"
                v-for="page in paginationPages"
                :key="page"
                :class="{ active: page === currentPage }"
                @click="changePage(page)"
            >
                {{ page }}
            </button>
            <button class="page-btn" :disabled="currentPage === lastPage" @click="changePage(currentPage + 1)">Next</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from '../axios'

const products = ref([])
const comments = ref([])
const filters = ref({
    product_id: '',
    keyword: '',
})
const perPage = ref(15)
const currentPage = ref(1)
const lastPage = ref(1)

const getProducts = async () => {
    try {
        const response = await axios.get('/api/products', {
            params: {
                per_page: 100,
            },
        })
        products.value = response.data.data || []
    } catch (error) {
        console.error(error)
    }
}

const getComments = async (page = 1) => {
    try {
        currentPage.value = page
        const response = await axios.get('/api/product-comments', {
            params: {
                page,
                per_page: perPage.value,
                keyword: filters.value.keyword,
                product_id: filters.value.product_id,
            },
        })

        const payload = response.data
        comments.value = payload.data || []
        currentPage.value = payload.current_page || 1
        lastPage.value = payload.last_page || 1
    } catch (error) {
        console.error(error)
    }
}

const changePage = (page) => {
    if (page < 1 || page > lastPage.value) return
    getComments(page)
}

const toggleHidden = async (comment) => {
    try {
        const response = await axios.patch(`/api/product-comments/${comment.id}/toggle-hidden`)
        comment.is_hidden = response.data.is_hidden
    } catch (error) {
        console.error(error)
        alert('Không thể cập nhật comment')
    }
}

const paginationPages = computed(() => {
    const pages = []
    const start = Math.max(1, currentPage.value - 2)
    const end = Math.min(lastPage.value, currentPage.value + 2)

    for (let page = start; page <= end; page++) {
        pages.push(page)
    }
    return pages
})

onMounted(async () => {
    await getProducts()
    await getComments()
})
</script>

<style scoped>
.page-card {
    padding: 24px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
}

.page-header h1 {
    font-size: 24px;
    margin: 0;
}

.card-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.select-input,
.text-input {
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    min-width: 220px;
}

.btn {
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    color: white;
}

.btn-primary {
    background: #2563eb;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-success {
    background: #16a34a;
    color: white;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 14px 12px;
    border: 1px solid #e5e7eb;
    text-align: left;
}

.badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-secondary {
    background: #e5e7eb;
    color: #475569;
}

.pagination-box {
    display: flex;
    gap: 8px;
    margin-top: 16px;
}

.page-btn {
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    cursor: pointer;
    background: white;
}

.page-btn.active {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
