<template>
  <div>
    <!-- <b-row align-v="center" class="loader" v-if="is_saving">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row> -->
    <div style="min-height:100%;">
        <b-row class="m-0">
            <b-col cols="4" class="p-2 bg-dark">
                <b-row class="m-0">
                    <b-col cols="2" class="text-center p-1 bg-success text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="search" class="h3 mb-0" />
                    </b-col>
                    <b-col class="p-2 bg-white">
                        <input  type="text" 
                                class="form-control" 
                                placeholder="Search..." 
                                v-model="search_key"
                                debounce="500"
                               />
                    </b-col>
                </b-row>
                <div class="list-group bg-white mt-2" style="max-height:260px;overflow-y: auto;">
                    <a href="#" class="list-group-item list-group-item-action" v-for="product in products" @click.prevent="selectProduct(product)">{{product.name}}</a>
                </div>
            </b-col>
            <b-col class="py-0 px-0">
            <b-form @submit.prevent="addToCart">
                <div class="card bg-light m-0 p-0 ml-2">
                    <div class="card-header bg-dark text-white m-0">
                        <h6 class="mb-0"><font-awesome-icon icon="info-circle" /> Product Details</h6>
                    </div>
                    <div class="card-body p-2 position-relative">
                        <b-row align-v="center" class="loader" v-if="loading || typeof selected_product.name === 'undefined'">
                            <b-col>
                                <strong>No Selected Product</strong>
                            </b-col>
                        </b-row>
                        <b-row class="m-0">
                            <b-col cols="1" class="text-center p-2 bg-info text-white d-flex align-items-center justify-content-center">
                                <font-awesome-icon icon="cube" class="h2 mb-0" />
                            </b-col>
                            <b-col class="p-2 bg-white d-flex align-items-center">
                                <div>
                                <h6 class="mb-0 text-muted">Product</h6>
                                <h2 class="mb-0"><strong>{{selected_product.name}}</strong></h2>
                                <h6 class="mb-0 text-info">{{selected_product.code}}</h6>
                                </div>
                            </b-col>
                        </b-row>

                        <b-row class="m-0 mt-1">
                            <b-col cols="6" class="p-0 pr-1">
                                <b-row class="m-0 mt-2">
                                    <b-col cols="2" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
                                        <font-awesome-icon icon="balance-scale" class="h2 mb-0" />
                                    </b-col>
                                    <b-col class="p-2 bg-white d-flex align-items-center">
                                    <div class="w-100">
                                        <h6 class="mb-1 text-muted">Unit</h6>
                                        <select class="form-control" v-model="form.unit_id" @change="changeUnit($event)">
                                            <option value="">Please Select</option>
                                            <option v-for="product_unit in product_units" :value="product_unit.unit.id">
                                                {{product_unit.unit.name}}
                                            </option>
                                        </select>
                                    </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col cols="6" class="p-0 pl-1">
                                <b-row class="m-0 mt-2">
                                    <b-col cols="2" class="text-center p-2 bg-primary text-white d-flex align-items-center justify-content-center">
                                        <font-awesome-icon icon="tag" class="h2 mb-0" />
                                    </b-col>
                                    <b-col class="p-2 bg-white d-flex align-items-center">
                                        <div class="w-100">
                                            <b-row>
                                                <b-col class="pr-1">
                                                    <h6 class="mb-1 text-muted">Price Type</h6>
                                                    <div class="input-group">
                                                        <select class="form-control" v-model="form.price_type" @change="changePriceType($event)">
                                                            <option value="1-1">Regular Price</option>
                                                            <optgroup label="Other Price Categories">
                                                                <template v-for="product_unit_price in product_unit_prices">
                                                                    <option :value="'2-'+product_unit_price.price_category_id">
                                                                        {{product_unit_price.price}} - {{product_unit_price.price_category.name}}
                                                                    </option>
                                                                </template>
                                                            </optgroup>
                                                            <option value="3-1">Custom Price</option>
                                                        </select>
                                                    </div>
                                                </b-col>
                                                <b-col class="pl-1">
                                                    <h6 class="mb-1 text-muted">Price</h6>
                                                    <div class="input-group">
                                                        <input  type="number" 
                                                                class="form-control" 
                                                                placeholder="0.00"
                                                                step="any"
                                                                min="0" 
                                                                v-model="form.price.value"
                                                                :disabled="form.price.disabled" />
                                                    </div>
                                                </b-col>
                                            </b-row>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>

                        <b-row class="m-0 mt-2">
                            <b-col cols="6" class="p-0 pr-1">
                                <b-row class="m-0 mt-2">
                                    <b-col cols="2" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                                        <font-awesome-icon icon="sitemap" class="h2 mb-0" />
                                    </b-col>
                                    <b-col class="p-2 bg-white d-flex align-items-center">
                                        <div class="w-100">
                                            <h6 class="mb-1 text-muted">Warehouse</h6>
                                            <select class="form-control" v-model="form.product_location_id">
                                                <option value="">Please Select</option>
                                                <option v-for="location_starting_inventory in location_starting_inventories" :value="location_starting_inventory.product_location_id">
                                                    {{location_starting_inventory.product_location.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col cols="6" class="p-0 pl-1">
                                <b-row class="m-0 mt-2">
                                    <b-col cols="2" class="text-center p-2 bg-danger text-white d-flex align-items-center justify-content-center">
                                        <font-awesome-icon icon="sort" class="h2 mb-0" />
                                    </b-col>
                                    <b-col class="p-2 bg-white d-flex align-items-center">
                                        <div class="w-100">
                                            <h6 class="mb-1 text-muted">Qty</h6>
                                            <input  type="number" 
                                                    class="form-control" 
                                                    placeholder="0.00"
                                                    step="any"
                                                    min="1" 
                                                    v-model="form.qty" />
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>

                        <b-row class="m-0 mt-3">
                            <b-col class="p-0">
                                <b-button type="submit" block variant="success" size="lg"><font-awesome-icon icon="cart-plus" /> Add to Cart</b-button>
                            </b-col>
                        </b-row>

                        
                        
                    </div>
                </div>
            </b-form>
            </b-col>
        </b-row>
    </div>
    <!-- START OF AUTHORIZATION MODAL -->
    <b-modal v-model="authorization_modal" centered size="md" body-class="p-0" :hide-footer="true" :hide-header="true">
            <authorization-component @authorizationCompleted="authorizationCompleted"/>
    </b-modal>
    <!-- END OF AUTHORIZATION MODAL -->
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    import AuthorizationComponent from '@/views/helpers/AuthorizationComponent.vue';
    export default {
      mixins:[SwalMixin],
      components: {AuthorizationComponent},
      data() {
        return {
          loading:false,
          search_key:'',
          searchTimeout: () => ({
            type: Function,
            default: () => ({})
          }),
          authorization_modal:false,
          products:[],
          product_units:[],
          product_unit_prices:[],
          location_starting_inventories:[],
          selected_product:{},
          form:{
              authorization_code_designation_id:'',
              product_id:'',
              unit_id:'',
              price_category_id:'',
              price_type:'1-1',
              price:{
                  value:0.00,
                  disabled:true
              },
              base_unit_qty:0.00,
              product_unit_id:'',
              product_location_id:"",
              qty:1,
              total:0.00,
              product_details:{}
          }
        }
      },
      watch: {
        search_key:{
            immediate: true,
            handler(){
                if(this.search_key!='')
                this.getProducts();
            }
        }
      },
      created(){
        //this.getProducts();
      },
      methods: {
        // searching() {
        //     this.loading = true;
        //     clearTimeout(this.searchTimeout);
        // },
        // search() {
        //     this.searchTimeout = setTimeout(() => {
        //         this.getProducts();
        //         clearTimeout(this.searchTimeout);
        //     }, 1000);
        // },
        getProducts(){
            this.is_saving=true;
            this.axios.get('products/search?search=' + this.search_key).then(response => {
                this.products=response.data
                this.loading = false;
            }).catch(error => console.log(error));
        },
        selectProduct(product){
            this.selected_product=product;
            this.product_units=product.product_units;

            let default_unit = product.product_units.find(x => x.is_base_unit === true);
            this.form.unit_id=default_unit.unit_id;

            this.product_unit_prices=default_unit.product_unit_prices;
            this.form.price.value=default_unit.price;

            let default_warehouse = product.location_starting_inventories.find(x => x.product_location.is_default === 1);
            if(default_warehouse){
                this.form.product_location_id=default_warehouse.product_location_id;
            }
            this.location_starting_inventories=product.location_starting_inventories;
            
        },
        changeUnit(event){
            let unit_id = parseInt(event.target.value);
            let new_unit = this.selected_product.product_units.find(x => x.unit_id === unit_id);
            this.product_unit_prices=new_unit.product_unit_prices;
            this.form.price.value=new_unit.price;
        },
        changePriceType(event){
            let price_type = event.target.value.split("-");
            if(price_type[0]=='3'){
                this.form.price.disabled=false;
                this.form.price.value='';
                this.form.price_category_id='';
            }else if(price_type[0]=='2'){
                let price_category_id = parseInt(price_type[1]);
                let unit = this.selected_product.product_units.find(x => x.unit_id === this.form.unit_id);
                let product_unit_price = unit.product_unit_prices.find(x => x.price_category_id === price_category_id);
                this.form.price.disabled=true;
                this.form.price.value=product_unit_price.price;
                this.form.price_category_id=price_category_id;
            }else if(price_type[0]=='1'){
                let unit = this.selected_product.product_units.find(x => x.unit_id === this.form.unit_id);
                this.form.price.disabled=true;
                this.form.price.value=unit.price;
                this.form.price_category_id='';
            }
        },
        addToCart(){
            this.form.product_details = this.selected_product;
            let price_type = this.form.price_type.split('-');
            if(price_type[0]=='3'){
                this.authorization_modal=true;
            }else{
                this.$emit('addToCart',this.form);
            }
                
            
        },
        authorizationCompleted(authorization_code_designation){
            this.form.authorization_code_designation_id=authorization_code_designation.id;
            this.authorization_modal=false;
            this.$emit('addToCart',this.form);
        }
      }
    }
</script>
