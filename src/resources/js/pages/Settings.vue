<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'

const loading = ref(false)
const errors = ref([])

const oldLogo = ref('')
const oldFavicon = ref('')

const form = ref({
    site_name: '',
    slogan: '',

    logo: null,
    favicon: null,

    primary_color: '#0d8fd8',
    secondary_color: '#28a745',

    email: '',
    phone: '',
    address: '',

    facebook: '',
    instagram: '',
    youtube: '',
    tiktok: '',
    zalo: '',

    footer_text: '',
    copyright: '',

    meta_title: '',
    meta_description: '',
    meta_keywords: '',

    google_map: ''
})

/*
|--------------------------------------------------------------------------
| Get Setting
|--------------------------------------------------------------------------
*/

const getSetting = async () => {
    try {

        loading.value = true

        const response = await axios.get('/api/settings')

        const setting = response.data

        form.value.site_name = setting.site_name
        form.value.slogan = setting.slogan

        form.value.primary_color = setting.primary_color
        form.value.secondary_color = setting.secondary_color

        form.value.email = setting.email
        form.value.phone = setting.phone
        form.value.address = setting.address

        form.value.facebook = setting.facebook
        form.value.instagram = setting.instagram
        form.value.youtube = setting.youtube
        form.value.tiktok = setting.tiktok
        form.value.zalo = setting.zalo

        form.value.footer_text = setting.footer_text
        form.value.copyright = setting.copyright

        form.value.meta_title = setting.meta_title
        form.value.meta_description = setting.meta_description
        form.value.meta_keywords = setting.meta_keywords

        form.value.google_map = setting.google_map

        oldLogo.value = setting.logo_url
        oldFavicon.value = setting.favicon_url

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

const handleLogo = event => {

    form.value.logo = event.target.files[0]

}

const handleFavicon = event => {

    form.value.favicon = event.target.files[0]

}

/*
|--------------------------------------------------------------------------
| Update Setting
|--------------------------------------------------------------------------
*/

const updateSetting = async () => {

    try {

        loading.value = true

        errors.value = []

        const formData = new FormData()

        Object.keys(form.value).forEach(key => {

            if (form.value[key] !== null) {

                formData.append(
                    key,
                    form.value[key]
                )

            }

        })

        formData.append(
            '_method',
            'PUT'
        )

        await axios.post(
            '/api/settings',
            formData,
            {
                headers: {
                    'Content-Type':
                        'multipart/form-data'
                }
            }
        )

        alert(
            'Cập nhật cài đặt thành công'
        )

        getSetting()

    } catch (error) {

        if (
            error.response?.data?.errors
        ) {

            errors.value =
                Object.values(
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

onMounted(() => {

    getSetting()

})
</script>
<template>

    <div class="setting-page">

        <div class="page-header">

            <div>

                <h1>Website Settings</h1>

                <p>
                    Quản lý thông tin website
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
                updateSetting
            ">

                <!-- ====================== -->
                <!-- GENERAL -->
                <!-- ====================== -->

                <h2 class="section-title">
                    General
                </h2>

                <div class="form-group">

                    <label>
                        Website Name
                    </label>

                    <input type="text" v-model="form.site_name
                        ">

                </div>

                <div class="form-group">

                    <label>
                        Slogan
                    </label>

                    <input type="text" v-model="form.slogan
                        ">

                </div>

                <!-- ====================== -->
                <!-- LOGO -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Logo

                </h2>

                <div class="form-group">

                    <label>

                        Website Logo

                    </label>

                    <div v-if="
                        oldLogo
                    " class="preview-image">

                        <img :src="oldLogo" alt="">

                    </div>

                    <input type="file" @change="
                        handleLogo
                    ">

                </div>

                <!-- ====================== -->
                <!-- FAVICON -->
                <!-- ====================== -->

                <div class="form-group">

                    <label>

                        Favicon

                    </label>

                    <div v-if="
                        oldFavicon
                    " class="preview-image">

                        <img :src="oldFavicon" width="60" alt="">

                    </div>

                    <input type="file" @change="
                        handleFavicon
                    ">

                </div>

                <!-- ====================== -->
                <!-- THEME -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Theme

                </h2>

                <div class="form-row">

                    <div class="form-group">

                        <label>

                            Primary Color

                        </label>

                        <input type="color" v-model="form.primary_color">

                    </div>

                    <div class="form-group">

                        <label>

                            Secondary Color

                        </label>

                        <input type="color" v-model="form.secondary_color">

                    </div>

                </div>
                <!-- ====================== -->
                <!-- CONTACT -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Contact

                </h2>

                <div class="form-row">

                    <div class="form-group">

                        <label>Email</label>

                        <input type="email" v-model="form.email">

                    </div>

                    <div class="form-group">

                        <label>Phone</label>

                        <input type="text" v-model="form.phone">

                    </div>

                </div>

                <div class="form-group">

                    <label>

                        Address

                    </label>

                    <textarea rows="4" v-model="form.address
                        " />

                </div>

                <!-- ====================== -->
                <!-- SOCIAL -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Social

                </h2>

                <div class="form-row">

                    <div class="form-group">

                        <label>

                            Facebook

                        </label>

                        <input type="text" v-model="form.facebook
                            ">

                    </div>

                    <div class="form-group">

                        <label>

                            Instagram

                        </label>

                        <input type="text" v-model="form.instagram
                            ">

                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label>

                            Youtube

                        </label>

                        <input type="text" v-model="form.youtube
                            ">

                    </div>

                    <div class="form-group">

                        <label>

                            TikTok

                        </label>

                        <input type="text" v-model="form.tiktok
                            ">

                    </div>

                </div>

                <div class="form-group">

                    <label>

                        Zalo

                    </label>

                    <input type="text" v-model="form.zalo
                        ">

                </div>

                <!-- ====================== -->
                <!-- SEO -->
                <!-- ====================== -->

                <h2 class="section-title">

                    SEO

                </h2>

                <div class="form-group">

                    <label>

                        Meta Title

                    </label>

                    <input type="text" v-model="form.meta_title
                        ">

                </div>

                <div class="form-group">

                    <label>

                        Meta Description

                    </label>

                    <textarea rows="4" v-model="form.meta_description
                        " />

                </div>

                <div class="form-group">

                    <label>

                        Meta Keywords

                    </label>

                    <input type="text" v-model="form.meta_keywords
                        ">

                </div>

                <!-- ====================== -->
                <!-- FOOTER -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Footer

                </h2>

                <div class="form-group">

                    <label>

                        Footer Text

                    </label>

                    <textarea rows="4" v-model="form.footer_text
                        " />

                </div>

                <div class="form-group">

                    <label>

                        Copyright

                    </label>

                    <input type="text" v-model="form.copyright
                        ">

                </div>

                <!-- ====================== -->
                <!-- GOOGLE MAP -->
                <!-- ====================== -->

                <h2 class="section-title">

                    Google Map

                </h2>

                <div class="form-group">

                    <label>

                        Embed Code

                    </label>

                    <textarea rows="6" v-model="form.google_map
                        " />

                </div>

                <button type="submit" class="submit-btn" :disabled="loading
                    ">

                    {{
                        loading
                            ? 'Đang lưu...'
                            : 'Lưu cài đặt'
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

.setting-page {
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

    box-shadow:
        0 2px 10px rgba(0, 0, 0, .08);

}

.section-title {

    font-size: 20px;

    font-weight: 700;

    color: #0f172a;

    margin-top: 35px;

    margin-bottom: 20px;

    padding-bottom: 10px;

    border-bottom:
        1px solid #e2e8f0;

}

.section-title:first-child {

    margin-top: 0;

}

.form-group {

    display: flex;

    flex-direction: column;

    margin-bottom: 22px;

}

.form-group label {

    font-weight: 600;

    margin-bottom: 10px;

    color: #334155;

}

.form-group input,

.form-group textarea,

.form-group select {

    width: 100%;

    padding: 14px 16px;

    border:

        1px solid #cbd5e1;

    border-radius: 12px;

    outline: none;

    transition: .25s;

    font-size: 15px;

}

.form-group textarea {

    resize: vertical;

}

.form-group input:focus,

.form-group textarea:focus,

.form-group select:focus {

    border-color: #2563eb;

    box-shadow:

        0 0 0 3px rgba(37, 99, 235, .15);

}

.form-row {

    display: grid;

    grid-template-columns:

        repeat(2, 1fr);

    gap: 20px;

}

.preview-image {

    margin-bottom: 15px;

}

.preview-image img {

    width: 220px;

    border-radius: 12px;

    border:

        1px solid #e2e8f0;

    padding: 8px;

    background: #fff;

}

input[type="file"] {

    padding: 10px;

}

input[type="color"] {

    width: 90px;

    height: 50px;

    padding: 4px;

    cursor: pointer;

    border-radius: 10px;

}

.error-box {

    background: #fee2e2;

    color: #991b1b;

    padding: 16px;

    border-radius: 12px;

    margin-bottom: 25px;

}

.error-box ul {

    padding-left: 20px;

}

.submit-btn {

    margin-top: 20px;

    border: none;

    background: #2563eb;

    color: #fff;

    padding:

        15px 28px;

    border-radius: 12px;

    cursor: pointer;

    font-size: 15px;

    font-weight: 600;

    transition: .25s;

}

.submit-btn:hover {

    background: #1d4ed8;

}

.submit-btn:disabled {

    opacity: .6;

    cursor: not-allowed;

}

@media(max-width:768px) {

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

input[type="color"] {
    width: 60px !important;
    height: 40px;
    padding: 2px;
    border: 1px solid #ddd;
    border-radius: 8px;
    cursor: pointer;
    background: transparent;
}


img {
  max-width: 1px !important;
  height: auto;
}

</style>