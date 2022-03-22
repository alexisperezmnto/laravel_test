<template>
    <v-app>
        <div class="row background">
            <div class="col-md-12">

            <div style="margin-top: 100px; margin-bottom: 30px">
              <v-btn
                color="primary"
                class="mb-2"
                @click="openDialog"
                >
                  Nuevo Producto
              </v-btn>
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
                        <v-dialog
                        v-model="dialog"
                        max-width="500px"
                        >
                        
                        <v-card>
                            <v-form ref="form">
                              <v-card-title>
                              <span class="text-h5">{{ formTitle }}</span>
                              </v-card-title>

                              <v-card-text>
                              <v-container>
                                  <v-row>
                                  <v-col
                                      cols="12"
                                  >
                                      <v-text-field
                                      clearable
                                      v-model="editedItem.name"
                                      label="Nombre"
                                      :error-messages="errorMessage.name"
                                      :rules="rules.name"
                                      ></v-text-field>
                                  </v-col>
                                  <v-col
                                      cols="12"
                                  >
                                      <v-textarea
                                      clearable
                                      no-resize
                                      rows="3"
                                      label="Descripción"
                                      v-model="editedItem.description"
                                      :error-messages="errorMessage.description"
                                      :rules="rules.description"
                                      ></v-textarea>
                                  </v-col>
                                  <v-col
                                      cols="12"
                                  >
                                      <v-text-field
                                      clearable
                                      v-model="editedItem.price"
                                      label="Precio"
                                      type="number"
                                      :error-messages="errorMessage.price"
                                      :rules="rules.price"
                                      ></v-text-field>
                                  </v-col>
                                  <v-col
                                      cols="12"
                                  >
                                      <v-select
                                          clearable
                                          v-model="editedItem.category"
                                          :items="categories"
                                          item-text="name"
                                          item-value="id"
                                          label="Categoría"
                                          multiple
                                          chips
                                          :error-messages="errorMessage.category"
                                          :rules="rules.category"
                                      ></v-select>
                                  </v-col>
                                  </v-row>
                              </v-container>
                              </v-card-text>

                              <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="close"
                              >
                                  Cancelar
                              </v-btn>
                              <v-btn
                                  color="blue darken-1"
                                  text
                                  @click="save"
                              >
                                  Guardar
                              </v-btn>
                              </v-card-actions>
                            </v-form>
                        </v-card>
                        </v-dialog>
                    </v-toolbar>

                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            @click="editItem(item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            @click="deleteItem(item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:item.description="{ item }">
                        <span class="description">{{item.description}}</span>
                    </template>
                    <template v-slot:item.categories="{ item }">
                        <v-chip v-for="cat in item.categories" :key="cat.id" class="chip">
                          <router-link :to="{path: `/categories/${cat.slug}`}" class="link">{{cat.name}}</router-link>
                        </v-chip>
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
      dialog: false,

      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Nombre', value: 'name' },
        { text: 'Descripción', value: 'description', width: '30%' },
        { text: 'Precio', value: 'price' },
        { text: 'Categorías', value: 'categories' },
        { text: 'Acciones', value: 'actions', sortable: false },
      ],

      products: [],
      categories: [],
      editedIndex: -1,

      editedItem: {
        name: '',
        description: '',
        price: '',
        category: []
      },

      defaultItem: {
        name: '',
        description: '',
        price: '',
        category: []
      },
      
      rules: {
        name: [
          v => !!v || 'El campo nombre del producto es obligatorio'
        ],
        description: [
          v => !!v || 'El campo descripción del producto es obligatorio',
          v => (v && v.length >= 15) || 'El campo descripción debe tener entre 15 hasta 800 caracteres',
        ],
        price: [
          v => !!v || 'El campo precio del producto es obligatorio',
        ],
        category: [
          v => !!v || 'El campo categoría del producto es obligatorio',
          v => v && v.length > 0 || 'El campo categoría del producto es obligatorio'
        ]
      },

      errorMessage: {
        name: '',
        description: '',
        price: '',
        category: ''
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Nuevo Producto' : 'Actualizar Producto'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      openDialog () {
        this.dialog = true
      },
      async initialize () {
        const prods = await axios.get(`/api/products`)
        this.products = prods.data
        
        const cats = await axios.get(`/api/categories`)
        this.categories = cats.data.map( cat => {
            return {
                id: cat.id,
                name: cat.name
            }
        })
      },

      editItem (item) {
        this.editedIndex = this.products.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.category = this.editedItem.categories.map(cat => cat.id)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.products.indexOf(item)
        this.editedItem = Object.assign({}, item)
        
        this.$swal({
          title: '¿Está seguro de eliminar el producto?',
          showCancelButton: true,
          confirmButtonText: 'Ok',
          cancelButtonText: `Cancelar`,
          background: '#161D31',
          icon: 'question'
        }).then(async (result) => {
          if(result.isConfirmed) {
            try {
              await axios.delete(`/api/products/${this.editedItem.id}`)
              this.products.splice(this.editedIndex, 1)
              this.$swal({
                title: 'Producto eliminado correctamente',
                background: '#161D31',
                icon: 'success'
              })
            } catch(error) {
              console.log(error.response.data)
              this.$swal({
                title: 'Hubo un error',
                background: '#161D31',
                icon: 'error'
              })
            }
          }
          
          this.close()
          
        })

      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1

          if (this.$refs['form']) {
            this.$refs.form.reset();
          }

          this.errorMessage = {
            name: '',
            description: '',
            price: '',
            category: ''
          }
        })
      },

      async save () {
        if(!this.$refs.form.validate()) return
        
        this.$swal({
          title: `¿Está seguro de ${this.editedIndex > -1 ? 'actuliazar' : 'crear'} el producto?`,
          showCancelButton: true,
          confirmButtonText: 'Ok',
          cancelButtonText: `Cancelar`,
          background: '#161D31',
          icon: 'question'
        }).then(async (result) => {
          if(result.isConfirmed) {
            if(this.editedIndex > -1) {
              try {
                const resp = await axios.put(`/api/products/${this.editedItem.id}`, this.editedItem)
                Object.assign(this.products[this.editedIndex], resp.data)
                this.$swal({
                  title: 'Producto actualizado correctamente',
                  background: '#161D31',
                  icon: 'success'
                })
                this.close()
              } catch(error) {
                this.errorMessage = error.response.data
                this.$swal({
                  title: 'Hubo un error',
                  background: '#161D31',
                  icon: 'error'
                })
              }
            } else {
              try {
                const resp = await axios.post(`/api/products`, this.editedItem)
                this.products.unshift(resp.data)
                this.$swal({
                  title: 'Producto creado correctamente',
                  background: '#161D31',
                  icon: 'success'
                })
                this.close()
              } catch(error) {
                this.errorMessage = error.response.data
                this.$swal({
                  title: 'Hubo un error',
                  background: '#161D31',
                  icon: 'error'
                })
              }
            }
          }
        })
      },
    },
  }
</script>

<style>
  .link {
    text-decoration: none;        
  }

  .description {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
  }

  .chip {
    margin-right: 10px;
  }
  
</style>