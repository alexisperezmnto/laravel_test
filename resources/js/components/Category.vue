<template>
    <v-app>
        <div class="row background">
            <div class="col-md-12">
                
                <div style="margin-top: 100px; color: white">
                    <h2>{{category.name}}</h2>
                    <p>{{category.description}}</p> 
                </div>
                
                <v-data-table
                    :headers="headers"
                    :items="products"
                    sort-by="calories"
                    class="elevation-1"
                    :search="search"
                >
                    <template v-slot:top>
                    <v-toolbar
                        flat
                    >
                        <v-toolbar-title>Productos</v-toolbar-title>

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
                    <template v-slot:item.description="{ item }">
                        <span class="description">{{item.description}}</span>
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
        { text: 'Descripción', value: 'description', width: '60%' },
        { text: 'Precio', value: 'price' }
      ],

      category: {
          id: '',
          name: '',
          decription: '',
          price: ''
      },

      products: []
    }),

    created () {
      this.initialize()
      this.$emit('activeClass', true)
    },

    methods: {
      async initialize () {
        const resp = await axios.get(`/api/categories/${this.$route.params.id}`)
        this.category = resp.data
        this.products = resp.data.products
      },
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