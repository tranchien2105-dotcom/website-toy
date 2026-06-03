import { defineStore } from 'pinia'
import axios from '../axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null
    }),

    actions: {

        async getProfile() {
            try {
                const res = await axios.get('/api/user')
                this.user = res.data
            } catch (err) {
                this.user = null
            }
        }
    }
})