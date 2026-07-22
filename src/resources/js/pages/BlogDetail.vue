<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRoute, useRouter } from 'vue-router'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

const editor = ClassicEditor

const route = useRoute()
const router = useRouter()

const blogId = route.params.id

const loading = ref(false)
const errors = ref([])

const oldImage = ref('')

const form = ref({
    title: '',
    description: '',
    image: null,
    category: '',
    status: 'Draft',
    date_from: '',
    date_to: '',
    comment: ''
})

/*
|--------------------------------------------------------------------------
| Get Blog Detail
|--------------------------------------------------------------------------
*/

const getBlogDetail = async () => {
    try {

        loading.value = true

        const response = await axios.get(
            `/api/blogs/${blogId}`
        )

        const blog = response.data

        form.value.title = blog.title
        form.value.description = blog.description
        form.value.category = blog.category
        form.value.status = blog.status
        form.value.comment = blog.comment

        form.value.date_from =blog.date_from
        form.value.date_to =blog.date_to
        
        oldImage.value = blog.image

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

const handleImage = event => {

    form.value.image =
        event.target.files[0]

}
/*
|--------------------------------------------------------------------------
| Update Blog
|--------------------------------------------------------------------------
*/

const updateBlog = async () => {

    try {

        loading.value = true
        errors.value = []

        const formData = new FormData()

        formData.append(
            'title',
            form.value.title
        )

        formData.append(
            'description',
            form.value.description
        )

        formData.append(
            'category',
            form.value.category
        )

        formData.append(
            'status',
            form.value.status
        )

        formData.append(
            'comment',
            form.value.comment
        )

        formData.append(
            'date_from',
            form.value.date_from
        )

        formData.append(
            'date_to',
            form.value.date_to
        )

        if (form.value.image) {

            formData.append(
                'image',
                form.value.image
            )

        }

        formData.append(
            '_method',
            'PUT'
        )

        await axios.post(
            `/api/blogs/${blogId}`,
            formData,
            {
                headers: {
                    'Content-Type':
                        'multipart/form-data'
                }
            }
        )

        alert(
            'Cập nhật Blog thành công'
        )

        router.push('/blogs')

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

/*
|--------------------------------------------------------------------------
| Mounted
|--------------------------------------------------------------------------
*/

onMounted(() => {

    getBlogDetail()

})
</script>

<template>
    <div class="blog-detail">

        <div class="page-header">
            <div>
                <h1>Chi tiết Blog</h1>
                <p>Cập nhật bài viết</p>
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

            <form @submit.prevent="updateBlog">

                <!-- Title -->
                <div class="form-group">
                    <label>Tiêu đề</label>

                    <input v-model="form.title" type="text">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label>Mô tả</label>

                    <!-- Nếu dùng CKEditor thì thay textarea bằng component -->
                    <ckeditor :editor="editor" v-model="form.description" />
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label>Danh mục</label>

                    <input v-model="form.category" type="text">
                </div>

                <!-- Image -->
                <div class="form-group">

                    <label>Ảnh Blog</label>

                    <div v-if="oldImage" class="preview-image">
                        <img :src="'/layout/images/blogs/' + oldImage" alt="">
                    </div>

                    <input type="file" @change="handleImage">

                </div>

                <!-- Comment -->
                <div class="form-group">
                    <label>Bình luận</label>

                    <input v-model="form.comment" type="number">
                </div>

                <!-- Date -->
                <div class="form-row">

                    <div class="form-group">

                        <label>Ngày bắt đầu</label>

                        
                        <input v-model="form.date_from" type="date">

                    </div>

                    <div class="form-group">

                        <label>Ngày kết thúc</label>

                        <input v-model="form.date_to" type="date">

                    </div>

                </div>
                <!-- Status -->
                <div class="form-group">
                    <label>Trạng thái</label>

                    <select v-model="form.status">
                        <option value="Draft">
                            Draft
                        </option>

                        <option value="Published">
                            Published
                        </option>

                        <option value="Archived">
                            Archived
                        </option>
                    </select>
                </div>

                <button type="submit" class="submit-btn" :disabled="loading">
                    {{
                        loading
                            ? 'Đang xử lý...'
                            : 'Cập nhật Blog'
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

.blog-detail {
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
    background: #fff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 22px;
}

.form-group label {
    margin-bottom: 10px;
    font-weight: 600;
    color: #334155;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    font-size: 14px;
    transition: .2s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
}

.form-group textarea {
    resize: vertical;
    min-height: 180px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.preview-image {
    margin-bottom: 15px;
}

.preview-image img {
    width: 320px;
    max-width: 100%;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.submit-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 14px 24px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.submit-btn:hover {
    background: #1d4ed8;
}

.submit-btn:disabled {
    opacity: .6;
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
    margin-left: 20px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .form-card {
        padding: 20px;
    }

    .page-header h1 {
        font-size: 26px;
    }
}
</style>