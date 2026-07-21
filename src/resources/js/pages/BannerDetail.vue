<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const bannerId = route.params.id

const loading = ref(false)
const errors = ref([])

const oldImage = ref('')

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
| Get Banner Detail
|--------------------------------------------------------------------------
*/

const getBannerDetail = async () => {
    try {
        loading.value = true

        const response = await axios.get(
            `/api/banners/${bannerId}`
        )

        const banner = response.data

        form.value.title = banner.title
        form.value.description = banner.description
        form.value.link_url = banner.link_url
        form.value.type = banner.type
        form.value.device = banner.device
        form.value.status = Number(
            banner.status
        )
        form.value.position =
            banner.position

        form.value.start_at =
            banner.start_at
                ? banner.start_at.slice(
                      0,
                      16
                  )
                : ''

        form.value.end_at =
            banner.end_at
                ? banner.end_at.slice(
                      0,
                      16
                  )
                : ''

        oldImage.value =
            banner.image_url
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
| Update Banner
|--------------------------------------------------------------------------
*/

const updateBanner = async () => {
    try {
        loading.value = true
        errors.value = []

        const formData =
            new FormData()

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

        formData.append(
            '_method',
            'PUT'
        )

        await axios.post(
            `/api/banners/${bannerId}`,
            formData,
            {
                headers: {
                    'Content-Type':
                        'multipart/form-data'
                }
            }
        )

        alert(
            'Cập nhật banner thành công'
        )

        router.push('/banners')
    } catch (error) {
        if (
            error.response?.data
                ?.errors
        ) {
            errors.value =
                Object.values(
                    error.response.data
                        .errors
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

onMounted(() => {
    getBannerDetail()
})
</script>

<template>
    <div class="banner-detail">

        <div class="page-header">
            <div>
                <h1>Chi tiết Banner</h1>
                <p>Cập nhật banner quảng cáo</p>
            </div>
        </div>

        <div class="form-card">

            <!-- Errors -->
            <div
                v-if="errors.length"
                class="error-box"
            >
                <ul>
                    <li
                        v-for="(
                            error,
                            index
                        ) in errors"
                        :key="index"
                    >
                        {{ error }}
                    </li>
                </ul>
            </div>

            <form
                @submit.prevent="
                    updateBanner
                "
            >
                <!-- Title -->
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input
                        v-model="
                            form.title
                        "
                        type="text"
                    >
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea
                        v-model="
                            form.description
                        "
                        rows="4"
                    />
                </div>

                <!-- Link -->
                <div class="form-group">
                    <label>Link URL</label>
                    <input
                        v-model="
                            form.link_url
                        "
                        type="text"
                    >
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label>
                        Ảnh banner
                    </label>

                    <div
                        v-if="
                            oldImage
                        "
                        class="preview-image"
                    >
                        <img
                            :src="'/layout/images/banners/' + oldImage"
                            alt=""
                        >
                    </div>

                    <input
                        type="file"
                        @change="
                            handleImage
                        "
                    >
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label>Loại banner</label>

                    <select
                        v-model="
                            form.type
                        "
                    >
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
                    <label>Thiết bị</label>

                    <select
                        v-model="
                            form.device
                        "
                    >
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
                    <label>Position</label>

                    <input
                        v-model="
                            form.position
                        "
                        type="number"
                    >
                </div>

                <!-- Start + End -->
                <div class="form-row">

                    <div class="form-group">
                        <label>
                            Start At
                        </label>

                        <input
                            v-model="
                                form.start_at
                            "
                            type="datetime-local"
                        >
                    </div>

                    <div class="form-group">
                        <label>
                            End At
                        </label>

                        <input
                            v-model="
                                form.end_at
                            "
                            type="datetime-local"
                        >
                    </div>

                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>
                        Trạng thái
                    </label>

                    <select
                        v-model="
                            form.status
                        "
                    >
                        <option
                            :value="1"
                        >
                            Active
                        </option>

                        <option
                            :value="0"
                        >
                            Inactive
                        </option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="submit-btn"
                    :disabled="
                        loading
                    "
                >
                    {{
                        loading
                            ? 'Đang xử lý...'
                            : 'Cập nhật Banner'
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

.banner-detail {
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
    box-shadow: 0 2px 10px rgba(0,0,0,.08);
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
    margin-bottom: 14px;
}

.preview-image img {
    width: 300px;
    border-radius: 12px;
}
</style>