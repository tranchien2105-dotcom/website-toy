<script setup>
import { ref } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

const editor = ClassicEditor

const router = useRouter()

const loading = ref(false)
const errors = ref([])

const previewImage = ref(null)

const form = ref({

    image: null,

    title: '',

    description: '',

    category: '',

    date_from: '',

    date_to: '',

    status: 'Draft'

})

/*
|--------------------------------------------------------------------------
| Handle Image
|--------------------------------------------------------------------------
*/

const handleImage = (event) => {

    const file = event.target.files[0]

    if (!file) return

    form.value.image = file

    previewImage.value =
        URL.createObjectURL(file)

}

/*
|--------------------------------------------------------------------------
| Create Blog
|--------------------------------------------------------------------------
*/

const addBlog = async () => {

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
            'date_from',
            form.value.date_from
        )

        formData.append(
            'date_to',
            form.value.date_to
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

        await axios.post(

            '/api/blogs/create',

            formData,

            {

                headers: {

                    'Content-Type':
                        'multipart/form-data'

                }

            }

        )

        toast.success(
            'Thêm Blog thành công 🚀'
        )

        router.push('/blogs')

    }

    catch (error) {

        if (
            error.response?.data?.errors
        ) {

            errors.value = Object.values(

                error.response.data.errors

            ).flat()

            toast.error(
                'Dữ liệu chưa hợp lệ'
            )

        } else {

            toast.error(
                'Có lỗi server'
            )

        }

    }

    finally {

        loading.value = false

    }

}
</script>

<template>

    <div class="blog-create">

        <div class="page-header">

            <div>

                <h1>Thêm Blog</h1>

                <p>Tạo bài viết mới</p>

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

            <form @submit.prevent="addBlog">

                <!-- Title -->

                <div class="form-group">

                    <label>

                        Tiêu đề

                    </label>

                    <input v-model="form.title" type="text" placeholder="Nhập tiêu đề bài viết">

                </div>

                <!-- Description -->

                <div class="form-group">

                    <label>

                        Nội dung

                    </label>

                    <ckeditor :editor="editor" v-model="form.description" />

                </div>

                <!-- Category -->

                <div class="form-group">

                    <label>

                        Danh mục

                    </label>

                    <input v-model="form.category" type="text" placeholder="Laravel, VueJS...">

                </div>

                <!-- Image -->

                <div class="form-group">

                    <label>

                        Ảnh Blog

                    </label>

                    <div v-if="previewImage" class="preview-image">

                        <img :src="previewImage">

                    </div>

                    <input type="file" accept="image/*" @change="handleImage">

                </div>

                <!-- Date -->

                <div class="form-row">

                    <div class="form-group">

                        <label>

                            Ngày bắt đầu

                        </label>

                        <input v-model="form.date_from" type="date">

                    </div>

                    <div class="form-group">

                        <label>

                            Ngày kết thúc

                        </label>

                        <input v-model="form.date_to" type="date">

                    </div>

                </div>

                <!-- Status -->

                <div class="form-group">

                    <label>

                        Trạng thái

                    </label>

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

                            : 'Thêm Blog'

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

.blog-create {
    padding: 10px;
}

.page-header {
    margin-bottom: 30px;
}

.page-header h1 {
    font-size: 32px;
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
.form-group select,
.form-group textarea {

    width: 100%;
    padding: 14px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    font-size: 15px;
    outline: none;
    transition: .3s;

}

.form-group input:focus,
.form-group select:focus {

    border-color: #2563eb;

}

.form-row {

    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;

}

.preview-image {

    margin-bottom: 15px;

}

.preview-image img {

    width: 300px;
    max-width: 100%;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid #e2e8f0;

}

.submit-btn {

    width: 100%;
    border: none;
    padding: 15px;
    background: #2563eb;
    color: white;
    border-radius: 12px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: .3s;

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

    padding-left: 20px;

}

/* ===========================
   CKEditor
=========================== */

:deep(.ck-editor__editable) {

    min-height: 350px;

}

:deep(.ck-editor__main) {

    border-radius: 0 0 12px 12px;

}

:deep(.ck-toolbar) {

    border-radius: 12px 12px 0 0;

}

:deep(.ck-content) {

    font-size: 15px;
    line-height: 1.8;

}

@media(max-width:768px) {

    .form-row {

        grid-template-columns: 1fr;

    }

}
</style>