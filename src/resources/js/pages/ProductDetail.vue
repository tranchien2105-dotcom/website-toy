<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRoute, useRouter } from 'vue-router'

const oldGallery = ref([])

const galleryImages = ref([])

const route = useRoute()

const router = useRouter()

const loading = ref(false)

const categories = ref([])

const errors = ref([])

const oldImage = ref('')

const productId = route.params.id

const productSlug = ref('')

const form = ref({
    category_id: '',
    name: '',
    price: '',
    stock: '',
    description: '',
    image: null,
    status: 1
})

/*
|--------------------------------------------------------------------------
| Get Categories
|--------------------------------------------------------------------------
*/

const getCategories = async () => {

    try {

        const response = await axios.get('/api/categories')

        categories.value = response.data

    } catch (error) {

        console.error(error)
    }
}

const handleGallery = (event) => {

    galleryImages.value = [...event.target.files]

}
/*
|--------------------------------------------------------------------------
| Get Product Detail
|--------------------------------------------------------------------------
*/

const getProductDetail = async () => {

    try {

        loading.value = true

        const response = await axios.get(
            `/api/products/${productId}`
        )

        const product = response.data

        form.value.category_id = product.category_id
        form.value.name = product.name
        form.value.price = product.price
        form.value.stock = product.stock
        form.value.description = product.description
        productSlug.value = product.slug

        // FIX STATUS
        form.value.status = Number(product.status)

        // IMAGE CŨ
        oldImage.value = product.image
        oldGallery.value = product.images || []

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false
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
| Update Product
|--------------------------------------------------------------------------
*/

const updateProduct = async () => {

    try {

        loading.value = true

        errors.value = []

        const formData = new FormData()

        formData.append(
            'category_id',
            form.value.category_id
        )

        formData.append(
            'name',
            form.value.name
        )

        formData.append(
            'price',
            form.value.price
        )

        formData.append(
            'stock',
            form.value.stock
        )

        formData.append(
            'description',
            form.value.description
        )

        formData.append(
            'status',
            form.value.status
        )

        if (form.value.image) {

            formData.append(
                'image',
                form.value.image
            )
        }

        galleryImages.value.forEach(image => {

            formData.append(
                'gallery[]',
                image
            )

        })

        formData.append('_method', 'PUT')

        await axios.post(
            `/api/products/${productId}`,
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        )

        alert(
            'Cập nhật sản phẩm thành công'
        )

        router.push('/products')

    } catch (error) {

        if (
            error.response?.data?.errors
        ) {

            errors.value = Object.values(
                error.response.data.errors
            ).flat()

        } else {

            errors.value.push(
                'Có lỗi xảy ra'
            )
        }

    } finally {

        loading.value = false
    }
}

onMounted(async () => {

    await getCategories()

    await getProductDetail()
})
</script>

<template>
    <div class="product-detail">

        <div class="page-header">

            <div>

                <h1>
                    Chi tiết sản phẩm
                </h1>

                <p>
                    Cập nhật thông tin sản phẩm
                </p>

            </div>

        </div>

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
            <form @submit.prevent="updateProduct">

                <!-- Category -->
                <div class="form-group">

                    <label>
                        Danh mục
                    </label>

                    <select v-model="form.category_id">

                        <option value="">
                            -- Chọn danh mục --
                        </option>

                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>

                    </select>

                </div>

                <!-- Name -->
                <div class="form-group">

                    <label>
                        Tên sản phẩm
                    </label>

                    <input v-model="form.name" type="text">

                </div>

                <!-- Price + Stock -->
                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Giá
                        </label>

                        <input v-model="form.price" type="number">

                    </div>

                    <div class="form-group">

                        <label>
                            Số lượng kho
                        </label>

                        <input v-model="form.stock" type="number">

                    </div>

                </div>

                <!-- Description -->
                <div class="form-group">

                    <label>
                        Mô tả
                    </label>

                    <textarea v-model="form.description" rows="5"></textarea>

                </div>

                <!-- Image -->
                <div class="form-group">

                    <label>
                        Ảnh sản phẩm
                    </label>

                    <!-- OLD IMAGE -->
                    <div v-if="oldImage" class="preview-image">
                        <img :src="'/layout/images/products/' + oldImage" alt="">
                    </div>

                    <!-- Upload New -->
                    <input type="file" @change="handleImage">

                </div>

                <!-- Product Gallery -->
                <div class="form-group">

                    <label>
                        Thư viện ảnh
                    </label>

                    <!-- Gallery hiện tại -->
                    <div v-if="oldGallery.length" class="gallery-grid">
                        <div v-for="image in oldGallery" :key="image.id" class="gallery-item">
                            <img :src="'/layout/images/products/' + productSlug + '/' + image.image" alt="">
                        </div>
                    </div>
                    
                    <!-- Upload nhiều ảnh -->
                    <input type="file" multiple accept="image/*" @change="handleGallery">

                    <p v-if="galleryImages.length" class="selected-count">
                        Đã chọn {{ galleryImages.length }} ảnh mới
                    </p>

                    <!-- Preview ảnh vừa chọn -->
                    <div v-if="galleryImages.length" class="gallery-grid">
                        <div v-for="(image, index) in galleryImages" :key="index" class="gallery-item">
                            <img :src="URL.createObjectURL(image)" alt="">
                        </div>
                    </div>

                </div>

                <!-- Status -->
                <div class="form-group">

                    <label>
                        Trạng thái
                    </label>

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
                            : 'Cập nhật sản phẩm'
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

.selected-count {
    margin: 12px 0;
    color: #2563eb;
    font-weight: 600;
}

.product-detail {
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

/* Preview Image */
.preview-image {
    margin-bottom: 14px;
}

.preview-image img {
    width: 220px;
    height: 220px;
    object-fit: cover;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
}

/* ==========================
   Product Gallery
========================== */

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 16px;
    margin-bottom: 15px;
}

.gallery-item {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    transition: .25s;
    background: white;
}

.gallery-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
}

.gallery-item img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}
</style>