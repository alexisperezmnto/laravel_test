<template>
    <div class="background">
        <v-app-bar fixed dark>
            <router-link to='/' @click.native="routerLinkClass" :class="[classProduct]">Productos</router-link>
            <router-link to='/categories' @click.native="routerLinkClass" :class="[classCategory]">Categorías</router-link>
        </v-app-bar>

        <div class="container">
            <router-view @activeClass="getActiveClass"></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                classProduct: 'routerLink',
                classCategory: 'routerLink'
            }
        },
        methods: {
            getActiveClass(value) {
                this.classProduct = 'routerLink'
                this.classCategory = 'routerLink activeLink'
            },

            routerLinkClass() {
                this.classProduct = 'routerLink'
                this.classCategory = 'routerLink'
            }
        }
    }
</script>