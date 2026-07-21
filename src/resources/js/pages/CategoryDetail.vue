<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const loading = ref(false)

const category = ref({
    name: '',
    slug: '',
    parent_id: '',
    description: '',
    status: 1
})

const parentCategories = ref([])

/*
|--------------------------------------------------------------------------
| Get Category
|--------------------------------------------------------------------------
*/

const getCategory = async () => {

    loading.value = true

    try {

        const response = await axios.get(`/api/categories/${route.params.id}`)

        category.value = response.data

    } catch (error) {

        console.log(error)

    } finally {

        loading.value = false

    }

}

/*
|--------------------------------------------------------------------------
| Get Parent Categories
|--------------------------------------------------------------------------
*/

const getParentCategories = async () => {

    const response = await axios.get('/api/categories')

    parentCategories.value = response.data

}

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/

const updateCategory = async () => {

    try {

        const response = await axios.put(
            `/api/categories/${route.params.id}`,
            category.value
        )

        alert(response.data.message)

        router.push('/categories')

    } catch (error) {

        alert(error.response.data.message)

    }

}

onMounted(() => {

    getCategory()

    getParentCategories()

})
</script>

<template>

    <div class="container">

        <h2>Chi tiết Category</h2>

        <div v-if="loading" class="loading">
            Loading...
        </div>

        <form v-else @submit.prevent="updateCategory">

            <div class="form-group">

                <label>Name</label>

                <input v-model="category.name" type="text">

            </div>

            <div class="form-group">

                <label>Parent Category</label>

                <select v-model="category.parent_id">

                    <option :value="null">
                        None
                    </option>

                    <option v-for="parent in parentCategories" :key="parent.id" :value="parent.id">
                        {{ parent.name }}
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Description</label>

                <textarea rows="5" v-model="category.description" />

            </div>

            <div class="form-group">

                <label>Status</label>

                <select v-model="category.status">

                    <option :value="1">
                        Hoạt động
                    </option>

                    <option :value="0">
                        Không hoạt động
                    </option>

                </select>

            </div>

            <div class="actions">

                <button class="save-btn" type="submit">
                    Update Category
                </button>

                <button type="button" class="cancel-btn" @click="router.back()">
                    Cancel
                </button>

            </div>

        </form>

    </div>

</template>

<style scoped>

.container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
}

h2 {
    margin-bottom: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

label {
    margin-bottom: 8px;
    font-weight: 600;
}

input,
textarea,
select {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 10px;
    outline: none;
}

textarea {
    resize: vertical;
}

.actions {
    margin-top: 30px;
    display: flex;
    gap: 12px;
}

.save-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 12px 22px;
    border-radius: 10px;
    cursor: pointer;
}

.cancel-btn {
    background: #64748b;
    color: white;
    border: none;
    padding: 12px 22px;
    border-radius: 10px;
    cursor: pointer;
}

.loading {
    text-align: center;
    padding: 30px;
}
</style>