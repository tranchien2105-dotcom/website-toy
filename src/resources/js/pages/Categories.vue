<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const categories = ref([])
const search = ref('')
const loading = ref(false)

/*
|--------------------------------------------------------------------------
| Get Categories
|--------------------------------------------------------------------------
*/

const getCategories = async () => {

    try {

        loading.value = true

        const response = await axios.get('/api/categories', {
            params: {
                search: search.value
            }
        })

        categories.value = response.data

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false

    }

}

/*
|--------------------------------------------------------------------------
| Add
|--------------------------------------------------------------------------
*/

const addCategory = () => {
    router.push('/categories/create')
}

/*
|--------------------------------------------------------------------------
| Edit
|--------------------------------------------------------------------------
*/

const editCategory = (category) => {
    router.push(`/categories/${category.id}`)
}

/*
|--------------------------------------------------------------------------
| Delete
|--------------------------------------------------------------------------
*/

const deleteCategory = (category) => {

    if (!confirm(`Bạn có chắc muốn xóa "${category.name}"?`)) {
        return
    }

    axios.delete(`/api/categories/${category.id}`)
        .then((response) => {

            alert(response.data.message)

            getCategories()

        })
        .catch((error) => {

            alert(error.response.data.message)

        })

}

watch(search, () => {

    getCategories()

})

onMounted(() => {

    getCategories()

})
</script>

<template>

    <div class="layout">

        <div class="content">

            <div class="header">

                <h2>Quản lý Category</h2>

                <div class="header-right">

                    <button class="add-btn" @click="addCategory">
                        + Thêm Category
                    </button>

                    <input v-model="search" type="text" placeholder="Tìm category..." class="search-input">

                </div>

            </div>

            <div v-if="loading" class="loading">
                Đang tải dữ liệu...
            </div>

            <table v-else class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <template v-for="category in categories" :key="category.id">

                        <!-- Parent -->

                        <tr>

                            <td>
                                <strong>{{ category.name }}</strong>
                            </td>

                            <td>{{ category.slug }}</td>

                            <td>-</td>

                            <td>{{ category.description ?? '-' }}</td>

                            <td>
                                <span class="status active" v-if="category.status">
                                    Active
                                </span>

                                <span class="status inactive" v-else>
                                    Inactive
                                </span>
                            </td>

                            <td>
                                <button class="edit-btn" @click="editCategory(category)">
                                    Edit
                                </button>

                                <button class="delete-btn" @click="deleteCategory(category)">
                                    Delete
                                </button>
                            </td>

                        </tr>

                        <!-- Children -->

                        <tr v-for="child in category.children" :key="child.id">

                            <td class="child-name">
                                └── {{ child.name }}
                            </td>

                            <td>{{ child.slug }}</td>

                            <td>{{ category.name }}</td>

                            <td>{{ child.description ?? '-' }}</td>

                            <td>
                                <span class="status active" v-if="child.status">
                                    Active
                                </span>

                                <span class="status inactive" v-else>
                                    Inactive
                                </span>
                            </td>

                            <td>
                                <button class="edit-btn" @click="editCategory(child)">
                                    Edit
                                </button>

                                <button class="delete-btn" @click="deleteCategory(child)">
                                    Delete
                                </button>
                            </td>

                        </tr>

                    </template>

                </tbody>

            </table>

        </div>

    </div>

</template>

<style scoped>
.layout {
    min-height: 100vh;
    background: #f4f7fb;
}

.content {
    background: white;
    padding: 24px;
    border-radius: 16px;
    width: 100%;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-right {
    display: flex;
    gap: 12px;
}

.search-input {
    width: 250px;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.add-btn {
    background: #10b981;
    color: #fff;
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #f8fafc;
    padding: 14px;
    text-align: left;
    border-bottom: 2px solid #e5e7eb;
}

.table td {
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:hover {
    background: #f9fafb;
}

.child-name {
    padding-left: 40px;
    color: #64748b;
}

.status {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.active {
    background: #dcfce7;
    color: #166534;
}

.inactive {
    background: #fee2e2;
    color: #991b1b;
}

.edit-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    margin-right: 8px;
}

.delete-btn {
    background: #ef4444;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
}

.loading {
    text-align: center;
    padding: 30px;
}
</style>