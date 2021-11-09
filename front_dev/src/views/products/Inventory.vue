<template>
  <div>
    <b-row align-v="center" class="loader" v-if="is_saving">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
    <b-row class="m-0">
      <b-col sm="4" class="p-0">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="info-circle" /> Product Details</h6>
          </div>
          <div class="card-body bg-white" v-if="typeof response_data.product !== 'undefined'">
              <b-form-group
                label="Product Name:"
                description="This field is required"
              >
                <b-form-input
                  v-model="response_data.product.name"
                  type="text"
                  disabled
                ></b-form-input>
              </b-form-group>

              <b-form-group
                label="Product Code:"
                description="This field is required"
              >
                <b-form-input
                  v-model="response_data.product.code"
                  type="text"
                  disabled
                ></b-form-input>
              </b-form-group>

              <b-form-group
                label="Product Brand:"
                description="This field is required"
              >
                <select class="form-control" v-model="response_data.product.brand_id" disabled>
                    <option value="">Please Select</option>
                    <option v-for="brand in response_data.brands" :value="brand.id">
                        {{brand.name}}
                    </option>
                </select>
              </b-form-group>

              <b-form-group
                label="Capital Price:"
                description="This field is required"
              >
                <b-form-input
                  v-model="response_data.product.capital"
                  type="number"
                  step="any"
                  disabled
                  placeholder="0.00"
                ></b-form-input>
              </b-form-group>

          </div>
        </div>
      </b-col>

      <b-col sm="4" class="p-0 pl-3" v-if="typeof this.response_data.product !== 'undefined'">

        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="cubes" /> Product Inventory</h6>
          </div>
          <div class="card-body bg-white">
            <template v-if="location_starting_inventories.length>0">
              <div class="alert alert-info" role="alert">
                <font-awesome-icon icon="info-circle"/> This will reset the inventory of the product.
              </div>
              <fieldset class="border p-3 position-relative" v-for="(location_starting_inventory,location_starting_inventory_index) in location_starting_inventories">
                <legend  class="w-auto mb-0"> 
                  <strong class="mx-1 text-uppercase">{{location_starting_inventory.product_location.name}}</strong>
                </legend>
                
                <b-row class="border mx-1 mb-3">
                  <b-col cols="3" class="text-center p-3 bg-info text-white">
                    <h1><font-awesome-icon icon="cubes" /></h1>
                  </b-col>
                  <b-col class="p-3">
                    <h5 class="mb-1">Total Remaining</h5>
                    <h4><strong>{{location_starting_inventory.qty}} {{default_unit.unit.name}}</strong></h4>
                  </b-col>
                </b-row>

                
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                  <label class="c-switch c-switch-pill c-switch-success mb-0">
                    <input type="checkbox" class="c-switch-input" v-model="location_starting_inventory.reset">
                    <span class="c-switch-slider"></span>
                  </label> 
                  <span class="ml-1">This will reset the inventory of the product.</span>
                </div>
                  <div class="input-group mb-3" v-for="(product_unit,product_unit_index) in location_starting_inventory.product_units">
                    
                    <input type="number" step="any" class="form-control" placeholder="0.00" v-model="product_unit.inventory" :disabled="!location_starting_inventory.reset">
                    <div class="input-group-append">
                      <div class="input-group-text bg-info text-white">
                        {{product_unit.unit.name}}
                      </div>
                    </div>
                  </div>
              </fieldset>
            </template>
            <div class="text-right mt-3">
              <router-link to="/products/all">
                <b-button variant="dark" size="sm" class="mr-1">
                  <font-awesome-icon icon="chevron-left" /> Back</b-button>
              </router-link>
              <b-button variant="dark" size="sm" @click="resetInventory"><font-awesome-icon icon="save" /> Save</b-button>
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
      data() {
        return {
          response_data:{},
          location_starting_inventories:[],
          default_unit:{}
        }
      },
      watch: {
        location_starting_inventories:{
          handler(value){
              this.location_starting_inventories.forEach(element => {
                element.qty = element.product_units.reduce((total, value)=>{
                      return total + (Number(value.inventory) * Number(value.base_unit_qty));
                  },0);
              });
          },
          deep:true,
          immediate:true
        }
      },
      created(){
        this.get(this.$route.params.id);
      },
      methods: {
        get(id){
          this.is_saving=true;
          this.axios.get('products/get',{params:{id:id}}).then(response => {
              this.response_data = response.data;

              this.default_unit = response.data.product.product_units.find(x => x.is_base_unit);
              let new_product_units = JSON.parse(JSON.stringify(this.response_data.product.product_units));
              let current_location_starting_inventories=JSON.parse(JSON.stringify(this.response_data.product.location_starting_inventories));
              new_product_units.forEach(product_unit => {
                product_unit.inventory=0;
              });


              this.response_data.product_locations.forEach(element => {
                let check = current_location_starting_inventories.find(x => x.product_location_id === element.id);
                if(!check){
                  let data={
                          product_id:this.response_data.product.id,
                          product_location_id:element.id,
                          qty:0,
                          id:-1,
                          reset:false,
                          product_units:JSON.parse(JSON.stringify(new_product_units)),
                          product_location:element
                  };
                  this.location_starting_inventories.push(data);
                }else{
                  check.product_units = JSON.parse(JSON.stringify(new_product_units));
                  check.qty=0;
                  check.reset=false;
                  this.location_starting_inventories.push(check);
                }
              });
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        resetInventory(){
          this.swalConfirmSubmit((data)=>{
              if (data.value) {
                this.is_saving=true;
                let form_data = {
                  location_starting_inventories:this.location_starting_inventories,
                  id:this.response_data.product.id
                }
                this.axios.post('products/reset_inventory',form_data).then(response => {
                    this.swal_transaction_completed_data.title="Success!"
                    this.swal_transaction_completed_data.text="Successfully setted the product inventory."
                    this.swalTransactionCompleted();
                    this.is_saving=false;
                }).catch(error => {
                    this.swalRequestError();
                    this.is_saving=false;
                });
              }
          });
        }
      }
    }
</script>
