<script setup>
import { ref } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'
import { toast } from 'vue3-toastify'

const router = useRouter()

const loading = ref(false)
const errors = ref([])

const previewImage = ref(null)

const form = ref({
    title: '',
    description: '',
    image: null,
    link_url: '',
    type: 'home',
    device: 'all',
    status: 1,
    position: 0,
    start_at: '',
    end_at: ''
})

/*
|--------------------------------------------------------------------------
| Handle Image
|--------------------------------------------------------------------------
*/

const handleImage = (event) => {

    const file = event.target.files[0]

    form.value.image = file

    if (file) {
        previewImage.value =
            URL.createObjectURL(file)
    }
}

/*
|--------------------------------------------------------------------------
| Create Banner
|--------------------------------------------------------------------------
*/

const addBanner = async () => {

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
            'link_url',
            form.value.link_url
        )

        formData.append(
            'type',
            form.value.type
        )

        formData.append(
            'device',
            form.value.device
        )

        formData.append(
            'status',
            form.value.status
        )

        formData.append(
            'position',
            form.value.position
        )

        formData.append(
            'start_at',
            form.value.start_at
        )

        formData.append(
            'end_at',
            form.value.end_at
        )

        if (form.value.image) {

            formData.append(
                'image',
                form.value.image
            )
        }

        await axios.post(
            '/api/banners/create',
            formData,
            {
                headers: {
                    'Content-Type':
                        'multipart/form-data'
                }
            }
        )

        toast.success(
            'Thêm banner thành công 🚀'
        )

        setTimeout(() => {

            router.push(
                '/banners'
            )

        }, 1500)

    } catch (error) {

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

    } finally {

        loading.value = false
    }
}
</script>

<template>

    <div class="banner-create">

        <div class="page-header">

            <div>
                <h1>
                    Thêm Banner
                </h1>

                <p>
                    Tạo banner mới
                </p>
            </div>

        </div>

        <div class="form-card">

            <!-- Errors -->
            <div v-if="errors.length" class="error-box">
                <ul>

                    <li v-for="(
error,
                                index
                        ) in errors" :key="index">
                        {{ error }}
                    </li>

                </ul>
            </div>

            <form @submit.prevent="
                addBanner
            ">

                <!-- Title -->
                <div class="form-group">
                    <label>
                        Tiêu đề
                    </label>

                    <input v-model="form.title
                        " type="text">
                </div>

                <!-- Description -->
                <div class="form-group">

                    <label>
                        Mô tả
                    </label>

                    <textarea v-model="form.description
                        " rows="4" />

                </div>

                <!-- Link -->
                <div class="form-group">

                    <label>
                        Link URL
                    </label>

                    <input v-model="form.link_url
                        " type="text">

                </div>

                <!-- Image -->
                <div class="form-group">

                    <label>
                        Ảnh Banner
                    </label>

                    <div v-if="
                        previewImage
                    " class="preview-image">
                        <img :src="previewImage" alt="">
                    </div>

                    <input type="file" @change="
                        handleImage
                    ">

                </div>

                <!-- Type -->
                <div class="form-group">

                    <label>
                        Type
                    </label>

                    <select v-model="form.type
                        ">
                        <option value="home">
                            Home
                        </option>

                        <option value="popup">
                            Popup
                        </option>

                        <option value="sidebar">
                            Sidebar
                        </option>
                    </select>

                </div>

                <!-- Device -->
                <div class="form-group">

                    <label>
                        Device
                    </label>

                    <select v-model="form.device
                        ">
                        <option value="all">
                            All
                        </option>

                        <option value="mobile">
                            Mobile
                        </option>

                        <option value="desktop">
                            Desktop
                        </option>
                    </select>

                </div>

                <!-- Position -->
                <div class="form-group">

                    <label>
                        Position
                    </label>

                    <input v-model="form.position
                        " type="number">

                </div>

                <!-- Date -->
                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Start At
                        </label>

                        <input v-model="form.start_at
                            " type="datetime-local">

                    </div>

                    <div class="form-group">

                        <label>
                            End At
                        </label>

                        <input v-model="form.end_at
                            " type="datetime-local">

                    </div>

                </div>

                <!-- Status -->
                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <select v-model="form.status
                        ">
                        <option :value="1">
                            Active
                        </option>

                        <option :value="0">
                            Inactive
                        </option>
                    </select>

                </div>

                <button type="submit" class="submit-btn" :disabled="loading
                    ">
                    {{
                        loading
                            ? 'Đang xử lý...'
                            : 'Thêm Banner'
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

.banner-create {
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
    background: white;
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
}

.form-group input,
.form-group textarea,
.form-group select {
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 14px 16px;
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
    cursor: pointer;
}

.error-box {
    background: #fee2e2;
    color: #991b1b;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 24px;
}

.preview-image {
    margin-bottom: 15px;
}

.preview-image img {
    width: 300px;
    border-radius: 12px;
}
</style>