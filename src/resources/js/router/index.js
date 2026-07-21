import { createRouter, createWebHistory } from 'vue-router'

import MainLayout from '../layouts/MainLayout.vue'
import AuthLayout from '../layouts/AuthLayout.vue'

import Home from '../pages/Home.vue'
import Products from '../pages/Products.vue'
import Banners from '../pages/Banners.vue'
import CreateProduct from '../pages/CreateProduct.vue'
import ProductDetail from '../pages/ProductDetail.vue'
import LoginView from '../pages/LoginView.vue'
import BannerDetail from '../pages/BannerDetail.vue'
import AddBanner from '../pages/AddBanner.vue'
import OrdersList from '../pages/OrdersList.vue'
import OrderDetail from '../pages/OrderDetail.vue'
import Categories from '../pages/Categories.vue'
import CategoryDetail from '../pages/CategoryDetail.vue'

const routes = [

    // ======================
    // ADMIN (có sidebar)
    // ======================
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: 'home',
                component: Home,
                meta: { requiresAuth: true }
            },
            {
                path: 'products',
                component: Products,
                meta: { requiresAuth: true }
            },
            {
                path: 'products/create',
                component: CreateProduct,
                meta: { requiresAuth: true }
            },
            {
                path: 'products/:id',
                component: ProductDetail,
                meta: { requiresAuth: true }
            },
            {
                path: '/banners/create',
                component: AddBanner
            },
            {
                path: 'banners',
                component: Banners,
                meta: { requiresAuth: true }
            }, {
                path: 'banners/:id',
                component: BannerDetail,
                meta: { requiresAuth: true }
            },
            {
                path: 'orders',
                component: OrdersList,
                meta: { requiresAuth: true }
            },
            {
                path: 'orders/:id',
                component: OrderDetail,
                meta: { requiresAuth: true }
            },
            {
                path: 'categories',
                component: Categories,
                meta: { requiresAuth: true }
            },
            {
                path: 'categories/:id',
                component: CategoryDetail,
                meta: { requiresAuth: true }
            }
        ]
    },

    // ======================
    // LOGIN
    // ======================
    {
        path: '/admin',
        component: AuthLayout,
        children: [
            {
                path: '',
                redirect: '/admin/login'
            },
            {
                path: 'login',
                component: LoginView
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

/*
|--------------------------------------------------------------------------
| AUTH GUARD (Vue 3 chuẩn)
|--------------------------------------------------------------------------
*/
router.beforeEach((to) => {

    const token = localStorage.getItem('token')

    // ❌ chưa login → chặn route cần auth
    if (to.meta.requiresAuth && !token) {
        return '/admin/login'
    }

    // ❌ đã login → không cho vào login page
    if (to.path === '/admin/login' && token) {
        return '/'
    }

    return true
})

export default router