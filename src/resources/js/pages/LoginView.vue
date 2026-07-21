<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const form = ref({
    email: '',
    password: ''
})

const loading = ref(false)

const error = ref('')

const login = async () => {

    error.value = ''

    loading.value = true

    try {

        const response = await axios.post(
            '/api/api-login',
            form.value
        )

        localStorage.setItem(
            'token',
            response.data.token
        )

        router.push('/home')

    } catch (err) {

        error.value =
            err.response?.data?.message ||
            'Login failed'

    } finally {

        loading.value = false
    }
}
</script>

<template>

    <div class="login-container">

        <div class="login-card">

            <h1>Login</h1>

            <div v-if="error" class="error">
                {{ error }}
            </div>

            <form @submit.prevent="login">

                <div class="form-group">

                    <label>Email</label>

                    <input type="email" v-model="form.email">
                </div>

                <div class="form-group">

                    <label>Password</label>

                    <input type="password" v-model="form.password">
                </div>

                <button :disabled="loading">

                    {{
                        loading
                            ? 'Loading...'
                            : 'Login'
                    }}

                </button>

            </form>

        </div>

    </div>

</template>

<style scoped>
.login-container {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f3f4f6;
}

.login-card {
    width: 350px;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    background: #111827;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}

.error {
    color: red;
    margin-bottom: 15px;
}
</style>