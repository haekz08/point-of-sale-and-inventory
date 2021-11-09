<template>
  <div>
    <b-row align-v="center" class="loader" v-if="is_saving">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
    <b-form @submit="save">
    <b-row class="m-0">
      <b-col sm="4" class="p-0">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="info-circle" /> Product Details</h6>
          </div>
          <div class="card-body bg-white">
              <b-form-group
                label="Product Name:"
                description="This field is required"
              >
                <b-form-input
                  v-model="form.name"
                  type="text"
                  required
                ></b-form-input>
              </b-form-group>

              <b-form-group
                label="Product Code:"
                description="This field is required"
              >
                <b-form-input
                  v-model="form.code"
                  type="text"
                  required
                ></b-form-input>
              </b-form-group>

              <b-form-group
                label="Product Brand:"
                description="This field is required"
              >
                <select class="form-control" v-model="form.brand_id" required>
                    <option value="">Please Select</option>
                    <option v-for="brand in fields.brands" :value="brand.id">
                        {{brand.name}}
                    </option>
                </select>
              </b-form-group>

              <b-form-group
                label="Capital Price:"
                description="This field is required"
              >
                <b-form-input
                  v-model="form.capital"
                  type="number"
                  step="any"
                  required
                  placeholder="0.00"
                ></b-form-input>
              </b-form-group>

              <fieldset class="border p-3">
                <legend  class="w-auto mb-0"> <strong>Base Unit</strong> </legend>
                <b-form-group
                  label="Unit:"
                  description="This field is required"
                >
                  <select class="form-control" v-model="form.default_unit.unit_id">
                      <option value="">Please Select</option>
                      <option v-for="unit in fields.units" :value="unit.id">
                          {{unit.name}}
                      </option>
                  </select>
                </b-form-group>
                
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text bg-dark text-white">
                      Regular Price
                    </div>
                  </div>
                  <input type="number" step="any" class="form-control" placeholder="0.00" v-model="form.default_unit.price" required>
                  <div class="input-group-append">
                    <b-button @click="openPriceCategoryModal(form.default_unit)" variant="info" size="sm" v-b-popover.hover="'Click to add new price option'" title="Add new Price option"><font-awesome-icon icon="plus"/></b-button>
                  </div>
                </div>

              <template v-if="form.default_unit.product_unit_prices.length>0">
              <div class="alert alert-info" role="alert">
                <font-awesome-icon icon="list"/> Other Price Options
              </div>

                <div class="input-group mb-2" v-for="(price_category, price_category_index) in form.default_unit.product_unit_prices">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                          {{price_category.price_category.name}}
                    </div>
                  </div>
                  <input type="number" step="any" class="form-control" placeholder="0.00" v-model="price_category.price" required>
                  <div class="input-group-append">
                    <b-button @click="removePriceCategoryFromDefaultUnit(price_category_index)" variant="danger" size="sm" v-b-popover.hover="'Click to remove this price option'" title="Remove"><font-awesome-icon icon="minus"/></b-button>
                  </div>
                </div>
              </template>

              </fieldset>

          </div>
        </div>
      </b-col>
      
      <b-col sm="4" class="p-0 pl-3">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="balance-scale" /> Other Product Units</h6>
          </div>
          <div class="card-body bg-white">
              <template v-if="form.product_units.length>0">
                <fieldset class="border p-3 position-relative" v-for="(product_unit,product_unit_index) in form.product_units">
                  <legend  class="w-auto mb-0"> 
                    <strong class="mx-1 text-uppercase">{{product_unit.unit.name}}</strong>
                  </legend>
                  <span class="h4 text-danger position-absolute cursor-pointer" 
                        style="top:5px;right:-10px"
                        v-b-popover.hover="'Click to remove this unit'" title="Remove"
                        @click="removeProductUnit(product_unit_index)">
                    <font-awesome-icon icon="times-circle"/>
                  </span>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-dark text-white">
                        Base Unit Qty
                      </div>
                    </div>
                    <input type="number" step="any" class="form-control" placeholder="0.00" v-model="product_unit.base_unit_qty" required>
                  </div>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-dark text-white">
                        Regular Price
                      </div>
                    </div>
                    <input type="number" step="any" class="form-control" placeholder="0.00" v-model="product_unit.price" required>
                    <div class="input-group-append">
                      <b-button @click="openPriceCategoryModal(product_unit)" variant="info" size="sm" v-b-popover.hover="'Click to add new price option'" title="Add new Price option"><font-awesome-icon icon="plus"/></b-button>
                    </div>
                  </div>

                <template v-if="product_unit.product_unit_prices.length>0">
                <div class="alert alert-info" role="alert">
                  <font-awesome-icon icon="list"/> Other Price Options
                </div>

                  <div class="input-group mb-2" v-for="(price_category,price_category_index) in product_unit.product_unit_prices">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                            {{price_category.price_category.name}}
                      </div>
                    </div>
                    <input type="number" step="any" class="form-control" placeholder="0.00" v-model="price_category.price" required>
                    <div class="input-group-append">
                      <b-button @click="removePriceCategoryFromOtherUnit(product_unit_index,price_category_index)" variant="danger" size="sm" v-b-popover.hover="'Click to remove this price option'" title="Remove"><font-awesome-icon icon="minus"/></b-button>
                    </div>
                  </div>
                </template>

                </fieldset>
                <br >
              </template>
              <div @click="openProductUnitModal" class="alert alert-secondary text-center cursor-pointer border" role="alert" v-b-popover.hover="'Click to add new product unit.'" title="Add New Unit">
                <span class="h1 text-dark">
                <font-awesome-icon icon="plus-circle" />
                </span>
              </div>
          </div>
        </div>
      </b-col>

      <b-col sm="4" class="p-0 pl-3">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="users" /> Product Suppliers</h6>
          </div>
          <div class="card-body bg-white">
            <div class="input-group">
              <select class="form-control" v-model="supplier_products_form.supplier">
                  <option value="">Please Select Supplier</option>
                  <option v-for="supplier in fields.suppliers" :value="supplier">
                      {{supplier.name}}
                  </option>
              </select>
              <div class="input-group-append">
                <b-button @click="addSupplier()" variant="info" size="sm" ><font-awesome-icon icon="plus"/> Add this Supplier</b-button>
              </div>
            </div>

            <ul class="list-group mt-3" v-if="form.supplier_products.length>0">
              <li class="list-group-item list-group-item-action  list-group-item-info">
                <font-awesome-icon icon="list"/> Supplier for this Product
              </li>
              <li  class="list-group-item d-flex justify-content-between align-items-center" v-for="(supplier_product, supplier_product_index) in form.supplier_products">
                {{supplier_product.supplier.name}}
                <span @click="removeSupplier(supplier_product_index)" class="text-danger h4 mb-0 cursor-pointer"  v-b-popover.hover="'Click to add remove supplier.'" title="Remove!"><font-awesome-icon icon="minus-circle"/></span>
              </li>
            </ul>

          </div>
        </div>

        <!-- <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="cubes" /> Product Inventory</h6>
          </div>
          <div class="card-body bg-white">
            <template v-if="fields.product_locations.length>0">
              <div class="alert alert-info" role="alert">
                <font-awesome-icon icon="info-circle"/> Please set the starting inventory of the product.
              </div>
              <fieldset class="border p-3 position-relative" v-for="(product_location,product_location_index) in fields.product_locations">
                <legend  class="w-auto mb-0"> 
                  <strong class="mx-1 text-uppercase">{{product_location.name}}</strong>
                </legend>
                  <div class="input-group mb-3" v-for="(product_unit,product_unit_index) in form.product_units">
                    
                    <input type="number" step="any" class="form-control" placeholder="0.00">
                    <div class="input-group-append">
                      <div class="input-group-text bg-dark text-white">
                        {{product_unit.unit.name}}
                      </div>
                    </div>
                  </div>
              </fieldset>
            </template>
          </div>
        </div> -->
      </b-col>
    </b-row>
    <div class="text-right mb-3">
      <router-link to="/products/all">
        <b-button v-if="form.id!=-1" variant="dark" size="sm" class="mr-1">
          <font-awesome-icon icon="chevron-left" /> Back</b-button>
      </router-link>
      <b-button type="submit" variant="dark" size="sm"><font-awesome-icon icon="save" /> Save</b-button>
    </div>
    </b-form>



    <!-- START OF ADD PRICE CATEGORY MODAL -->
        <b-modal v-model="price_category_modal" centered header-text-variant="light" header-bg-variant="dark" footer-bg-variant="dark"
                 no-close-on-backdrop no-close-on-esc header-class="p-3" footer-class="p-2" body-class="p-3" :hide-footer="true">
                <template slot="modal-title">
                    <h5 class="m-0"><font-awesome-icon icon="check-circle" /> Add new price option<span></span></h5>
                </template>
                <!-- BODY START -->
                <b-form v-on:submit.prevent="addPriceCategory">
                  <b-form-group
                    label="Price Option:"
                    description="This field is required"
                  >
                    <select class="form-control" v-model="price_category_form.price_category" required>
                        <option value="">Please Select</option>
                        <option v-for="price_category in fields.price_categories" :value="price_category">
                            {{price_category.name}}
                        </option>
                    </select>
                  </b-form-group>
                  
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-dark text-white">
                        Set Price
                      </div>
                    </div>
                    <input type="number" class="form-control" placeholder="0.00" step="any" v-model="price_category_form.price" required>
                  </div>
                  <!-- BODY END -->
                  <div class="text-right w-100">
                      <!-- <b-button
                          variant="secondary"
                          @click="addPriceCategory()">
                          Add
                      </b-button> -->
                      <b-button type="submit" variant="dark"> Add</b-button>
                  </div>
                </b-form>
        </b-modal>
        <!-- END OF ADD PRICE CATEGORY MODAL -->



        <!-- START OF ADD UNIT MODAL -->
        <b-modal v-model="product_unit_modal" centered header-text-variant="light" header-bg-variant="dark" footer-bg-variant="dark"
                 no-close-on-backdrop no-close-on-esc header-class="p-3" footer-class="p-2" body-class="p-3" :hide-footer="true">
                <template slot="modal-title">
                    <h5 class="m-0"><font-awesome-icon icon="check-circle" /> Add new product unit<span></span></h5>
                </template>
                <!-- BODY START -->
                <b-form v-on:submit.prevent="addProductUnit">
                  <b-form-group
                    label="Available Units:"
                    description="This field is required"
                  >
                    <select class="form-control" v-model="product_unit_form.unit">
                        <option value="">Please Select</option>
                        <option v-for="unit in fields.units" :value="unit" v-if="form.default_unit.unit_id!=unit.id">
                            {{unit.name}}
                        </option>
                    </select>
                  </b-form-group>
                  
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-dark text-white">
                        Base Unit Qty
                      </div>
                    </div>
                    <input type="number" step="any" class="form-control" placeholder="0.00" v-model="product_unit_form.base_unit_qty" required>
                  </div>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-dark text-white">
                        Regular Price
                      </div>
                    </div>
                    <input type="number" class="form-control" placeholder="0.00" step="any" v-model="product_unit_form.price" required>
                  </div>
                  <!-- BODY END -->
                  <div class="text-right w-100">
                      <!-- <b-button
                          variant="secondary"
                          @click="addPriceCategory()">
                          Add
                      </b-button> -->
                      <b-button type="submit" variant="dark"> Add</b-button>
                  </div>
                </b-form>
        </b-modal>
        <!-- END OF ADD UNIT MODAL -->

  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
      props:{
          form: {
              type: Object,
              default: () => {}
          }
      },
      data() {
        return {
          form_copy:{},
          is_saving:false,
          fields:[],
          price_category_modal:false,
          selected_unit:{},
          price_category_form:{
            price_category:"",
            price:""
          },
          product_unit_modal:false,
          product_unit_form:{
            unit:"",
            unit_id:'',
            price:0,
            is_base_unit:false,
            base_unit_qty:0,
            product_unit_prices:[]
          },
          supplier_products_form:{
            supplier:"",
            supplier_id:"",
            product_id:-1
          }
        }
      },
      created(){
        this.form_copy=JSON.parse(JSON.stringify(this.form));
        if(this.form.id!=-1)
        {
          this.get();
        }else{
          this.getFields();
        }
      },
      methods: {
        get(){
          this.is_saving=true;
          this.axios.get('products/get',{params:{id:this.form.id}}).then(response => {
              let data = response.data.product;

              let default_unit = data.product_units.find(x => x.is_base_unit);
              let default_index = data.product_units.indexOf(default_unit);
              
              data.product_units.splice(default_index, 1); 
              data.default_unit=default_unit;
              data.unit_id = default_unit.unit_id;

              this.form=data;
              this.is_saving=false;

              this.fields = response.data;
          }).catch(error => console.log(error));
        },
        getFields(){
          this.is_saving=true;
          this.axios.get('products/fields').then(response => {
              this.fields = response.data;
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        openPriceCategoryModal(unit){
          this.price_category_modal=true;
          this.selected_unit=unit;
        },
        addPriceCategory(){
          if(!this.checkifPriceCategoryExist(this.price_category_form.price_category.id)){
            if(this.selected_unit.is_base_unit){
              this.form.default_unit.product_unit_prices.push(this.price_category_form);
            }else{
              this.form.product_units[this.form.product_units.indexOf(this.selected_unit)].product_unit_prices.push(this.price_category_form);
            }
            
            this.price_category_form=JSON.parse(JSON.stringify(this.price_category_form));
            this.swal_transaction_completed_data.title="Price Category Added!"
            this.swal_transaction_completed_data.text="Successfully Added New Price Category."
            this.swalTransactionCompleted();
            this.price_category_modal=false;
          }else{
            this.swal_transaction_error_data.text="Price Category Already Exist."
            this.swalRequestError();
          }
          
        },
        checkifPriceCategoryExist(id){
          if(this.selected_unit.is_base_unit){
            if(this.form.default_unit.product_unit_prices.find(x => x.price_category.id === id))
            return true;
          }else{
            if(this.form.product_units[this.form.product_units.indexOf(this.selected_unit)].product_unit_prices.find(x => x.price_category.id === id))
            return true;
          }
        },
        openProductUnitModal(){
          this.product_unit_modal=true;
        },
        addProductUnit(){
          
          if(!this.checkifProductUnitExist(this.product_unit_form.unit.id)){
            this.product_unit_form.unit_id = this.product_unit_form.unit.id;

            this.form.product_units.push(this.product_unit_form);
            this.product_unit_form=JSON.parse(JSON.stringify(this.product_unit_form));
            this.swal_transaction_completed_data.title="Product Unit Added!"
            this.swal_transaction_completed_data.text="Successfully Added New Product Unit."
            this.swalTransactionCompleted();
            this.product_unit_modal=false;
          }else{
            this.swal_transaction_error_data.text="Product Unit Already Exist."
            this.swalRequestError();
          }
        },
        checkifProductUnitExist(unit_id){
          if(this.form.product_units.find(x => x.unit.id === unit_id))
          return true;
        },
        removePriceCategoryFromDefaultUnit(index){
          this.form.default_unit.product_unit_prices.splice(index, 1);
        },
        removePriceCategoryFromOtherUnit(product_unit_index,price_category_index){
          this.form.product_units[product_unit_index].product_unit_prices.splice(price_category_index, 1);
        },
        removeProductUnit(product_unit_index){
          this.swalConfirmDelete((data)=>{
              if (data.value) {
                this.form.product_units.splice(product_unit_index, 1);
              }
          });
        },
        addSupplier(){
          if(this.supplier_products_form.supplier==""){
            this.swal_transaction_error_data.text="Please Select Supplier"
            this.swalRequestError();
            return;
          }
          let check = this.form.supplier_products.find(x => x.supplier.id === this.supplier_products_form.supplier.id);
          if(!check){
            this.supplier_products_form.supplier_id = this.supplier_products_form.supplier.id;
            this.form.supplier_products.push(this.supplier_products_form);
            this.supplier_products_form=JSON.parse(JSON.stringify(this.supplier_products_form));
            this.swal_transaction_completed_data.title="Supplier Added!"
            this.swal_transaction_completed_data.text="Successfully Added New Supplier."
            this.swalTransactionCompleted();
          }else{
            this.swal_transaction_error_data.text="Supplier Already Exist."
            this.swalRequestError();
          }
        },
        removeSupplier(supplier_product_index){
          this.swalConfirmDelete((data)=>{
              if (data.value) {
                this.form.supplier_products.splice(supplier_product_index, 1);
              }
          });
        },
        save(){
          event.preventDefault()
          this.swalConfirmSubmit((data)=>{
              if (data.value) {
                this.is_saving=true;
                this.axios.post('products/save',this.form).then(response => {
                    this.swal_transaction_completed_data.title="Success!"
                    this.swal_transaction_completed_data.text="Successfully Added New Product."
                    this.swalTransactionCompleted();
                    this.is_saving=false;
                    if(this.form.id==-1){
                      this.form=JSON.parse(JSON.stringify(this.form_copy));
                    }
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