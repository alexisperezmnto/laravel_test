<template>
    <v-app>
        <div class="row background">
            <div class="col-md-12">
                <v-data-table
                    :headers="headers"
                    :items="categories"
                    sort-by="calories"
                    class="elevation-1 datatable"
                    :search="search"
                >
                    <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>Categorías</v-toolbar-title>

                        <v-spacer></v-spacer>
                        <v-text-field
                          v-model="search"
                          append-icon="mdi-magnify"
                          label="Buscar"
                          single-line
                          hide-details
                          class="search"
                          clearable
                        ></v-text-field>

                    </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <router-link :to="{path: `/categories/${item.slug}`}" class="routerLink">
                            <v-icon
                            >
                                mdi-eye 
                            </v-icon>
                        </router-link>
                    </template>
                    <template v-slot:item.description="{ item }">
                        <span class="description">{{item.description}}</span>
                    </template>
                    <template v-slot:item.products="{ item }">
                        {{item.products.length}}
                    </template>
                </v-data-table>
            </div>
        </div>
    </v-app>
</template>


<script>
  export default {
    data: () => ({
      search: '',
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Nombre', value: 'name' },
        { text: 'Descripción', value: 'description' },
        { text: 'Productos', value: 'products' },
        { text: 'Acciones', value: 'actions', sortable: false },
      ],

      categories: []
    }),

    created () {
      this.initialize()
    },

    methods: {
      
      async initialize () {
        const cats = await axios.get(`/api/categories`)
        this.categories = cats.data
      },

      async viewCategory (category) {
        //   const resp = await axios.get(`/api/categories/${category.slug}`)
          this.$router.push({ path: '/', query: { slug: category.slug }})
      }
    }
  }
</script>

<style>
    .description {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    
</style>