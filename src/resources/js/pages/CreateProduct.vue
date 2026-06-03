<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const loading = ref(false)

const categories = ref([])
const brands = ref([])

const errors = ref([])

const form = ref({
    category_id: '',
    brand_id: '',
    name: '',
    price: '',
    stock: 0,
    description: '',
    image: null,
    status: 1
})

/*
|--------------------------------------------------------------------------
| Get Categories + Brands
|--------------------------------------------------------------------------
*/

const getData = async () => {
    try {

        const [categoryRes, brandRes] = await Promise.all([
            axios.get('/api/categories'),
            
        ])

        categories.value = categoryRes.data
   

    } catch (error) {
        console.error(error)
    }
}

/*
|--------------------------------------------------------------------------
| Handle Image
|--------------------------------------------------------------------------
*/

const handleImage = (event) => {
    form.value.image = event.target.files[0]
}

/*
|--------------------------------------------------------------------------
| Submit Product
|--------------------------------------------------------------------------
*/

const submitProduct = async () => {

    try {

        loading.value = true
        errors.value = []

        const formData = new FormData()

        formData.append('category_id', form.value.category_id)
        formData.append('brand_id', form.value.brand_id)
        formData.append('name', form.value.name)
        formData.append('price', form.value.price)
        formData.append('stock', form.value.stock)
        formData.append('description', form.value.description)
        formData.append('status', form.value.status)

        if (form.value.image) {
            formData.append('image', form.value.image)
        }

        await axios.post('/api/products', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })

        alert('Thêm sản phẩm thành công')

        router.push('/products')

    } catch (error) {

        if (error.response?.data?.errors) {

            errors.value = Object.values(
                error.response.data.errors
            ).flat()

        } else {

            errors.value.push('Có lỗi xảy ra')
        }

    } finally {

        loading.value = false
    }
}

onMounted(() => {
    getData()
})
</script>

<template>
    <div class="create-product">

        <!-- Header -->
        <div class="page-header">

            <div>
                <h1>Thêm sản phẩm</h1>

                <p>
                    Tạo sản phẩm mới cho hệ thống
                </p>
            </div>

        </div>

        <!-- Card -->
        <div class="form-card">

            <!-- Errors -->
            <div v-if="errors.length" class="error-box">
                <ul>

                    <li v-for="(error, index) in errors" :key="index">
                        {{ error }}
                    </li>

                </ul>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitProduct">

                <!-- Category -->
                <div class="form-group">

                    <label>Danh mục</label>

                    <select v-model="form.category_id">

                        <option value="">
                            -- Chọn danh mục --
                        </option>

                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>

                    </select>

                </div>

                <!-- Brand -->
                <div class="form-group">

                    <label>Thương hiệu</label>

                    <select v-model="form.brand_id">

                        <option value="">
                            -- Chọn thương hiệu --
                        </option>

                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                            {{ brand.name }}
                        </option>

                    </select>

                </div>

                <!-- Name -->
                <div class="form-group">

                    <label>Tên sản phẩm</label>

                    <input v-model="form.name" type="text" placeholder="Nhập tên sản phẩm">

                </div>

                <!-- Price -->
                <div class="form-row">

                    <div class="form-group">

                        <label>Giá</label>

                        <input v-model="form.price" type="number" placeholder="Nhập giá">

                    </div>

                    <!-- Stock -->
                    <div class="form-group">

                        <label>Số lượng kho</label>

                        <input v-model="form.stock" type="number" placeholder="Nhập số lượng">

                    </div>

                </div>

                <!-- Description -->
                <div class="form-group">

                    <label>Mô tả</label>

                    <textarea v-model="form.description" rows="5" placeholder="Nhập mô tả sản phẩm"></textarea>

                </div>

                <!-- Image -->
                <div class="form-group">

                    <label>Ảnh sản phẩm</label>

                    <input type="file" @change="handleImage">

                </div>

                <!-- Status -->
                <div class="form-group">

                    <label>Trạng thái</label>

                    <select v-model="form.status">

                        <option :value="1">
                            Hoạt động
                        </option>

                        <option :value="0">
                            Ẩn
                        </option>

                    </select>

                </div>

                <!-- Submit -->
                <button type="submit" class="submit-btn" :disabled="loading">
                    {{
                        loading
                            ? 'Đang xử lý...'
                            : 'Thêm sản phẩm'
                    }}
                </button>

            </form>

        </div>

    </div>
</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.create-product {
    padding: 10px;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 32px;
    color: #0f172a;
    margin-bottom: 8px;
}

.page-header p {
    color: #64748b;
}

.form-card {
    background: white;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 22px;
}

.form-group label {
    margin-bottom: 10px;
    color: #1e293b;
    font-weight: 600;
}

.form-group input,
.form-group textarea,
.form-group select {
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 14px 16px;
    outline: none;
    font-size: 15px;
    transition: 0.3s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #3b82f6;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.submit-btn {
    border: none;
    background: #2563eb;
    color: white;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.submit-btn:hover {
    background: #1d4ed8;
}

.submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.error-box {
    background: #fee2e2;
    color: #991b1b;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.error-box ul {
    padding-left: 20px;
}
</style>