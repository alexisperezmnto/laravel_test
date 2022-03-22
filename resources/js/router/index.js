import Vue from 'vue'
import VueRouter from 'vue-router'
import Products from '../components/Products.vue'
import Categories from '../components/Categories.vue'
import Category from '../components/Category.vue'

Vue.use(VueRouter)

export const routes = [
    {
        path: '/categories',
        component: Categories
    },
    {
        path: '/categories/:id',
        component: Category
    },
    {
        path: '/',
        component: Products
    },
]