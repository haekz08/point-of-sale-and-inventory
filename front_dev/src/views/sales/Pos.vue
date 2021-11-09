<template>
  <div class="animated fadeIn">
    <b-row class="m-0">
      <b-col cols="3" class="px-2">
        <b-row class="m-0 mb-3">
          <b-col cols="3" class="text-center p-2 bg-info text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="cart-plus" class="h3 mb-0" />
          </b-col>
          <b-col class="p-2 bg-white cursor-pointer" @click="product_modal=true">
            <h5 class="mb-0 text-info">Add Product</h5>
            <h4 class="mb-0"><strong>(F2)</strong></h4>
          </b-col>
        </b-row>
      </b-col>

      <b-col cols="3" class="px-2">
        <b-row class="m-0 mb-3">
          <b-col cols="3" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="cog" class="h3 mb-0" />
          </b-col>
          <b-col class="p-2 bg-white" @click="sale_setting_modal=true">
            <h5 class="mb-0 text-warning">Sale Settings</h5>
            <h4 class="mb-0"><strong>(F6)</strong></h4>
          </b-col>
        </b-row>
      </b-col>

      <b-col cols="3" class="px-2">
        <b-row class="m-0 mb-3">
          <b-col cols="3" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="user" class="h3 mb-0" />
          </b-col>
          <b-col class="p-2 bg-white" @click="openPaymentModal()">
            <h5 class="mb-0 text-dark">AR PAYMENT</h5>
            <h4 class="mb-0"><strong>(F7)</strong></h4>
          </b-col>
        </b-row>
      </b-col>

      <b-col cols="3" class="px-2">
        <b-row class="m-0 mb-3">
          <b-col cols="3" class="text-center p-2 bg-success text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="search" class="h3 mb-0" />
          </b-col>
          <b-col class="p-2 bg-white" @click="transaction_finder_modal=true">
            <h5 class="mb-0 text-success">SO Finder</h5>
            <h4 class="mb-0"><strong>(F9)</strong></h4>
          </b-col>
        </b-row>
      </b-col>

    </b-row>
    
    <b-row class="m-0">
      <b-col cols="9" class="px-2">
        <b-row class="m-0 bg-white" style="min-height:100%">
          <b-col cols="12" class="p-0 bg-white">
            <table class="table mb-0 table-bordered table-sm">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Description</th>
                <th scope="col" class="text-center">Qty</th>
                <th scope="col" class="text-center">Price per Qty</th>
                <th scope="col" class="text-center">Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ticket_detail, index) in ticket.ticket_details">
                <th scope="row" class="text-center">{{index+1}}</th>
                <td>{{ticket_detail.product_unit.product.name}}</td>
                <td align="center"><number-format-component :input_value="ticket_detail.qty" :currency="false"/> {{ticket_detail.product_unit.unit.name}}</td>
                <td align="center"><span class="amount-100"><number-format-component :input_value="Number(ticket_detail.price)"/></span></td>
                <td align="center"><span class="amount-100"><strong><number-format-component :input_value="Number(ticket_detail.total)"/></strong></span></td>
                <td align="center"><font-awesome-icon icon="minus-circle" class="h5 text-danger mb-0 cursor-pointer" @click="deleteItem(ticket_detail.id)"/></td>
              </tr>
            </tbody>
          </table>

          </b-col>
        </b-row>
      </b-col>
      <b-col class="px-2">
        <b-row class="m-0">
          <b-col cols="12" class="p-2 border border-light bg-dark">
            <div class="list-group" style="background-color:#23242d;border-color:#181924;color:#768192!important">
              <li class="list-group-item list-group-item flex-column align-items-start text-center">
                <h2 class="mb-1 text-white">
                  <number-format-component :input_value="total_amount_due"/>
                </h2>
                <p class="mb-1 h4">Total Amount</p>
              </li>
            </div>

            <div class="list-group mt-2" style="background-color:#23242d;border-color:#181924;color:#768192!important">
              <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 text-light">
                    <template v-if="ticket.transaction_date.default!=''">
                      {{ticket.transaction_date.other_formats.format_1}}
                    </template>
                    <template v-else>
                      <span class="text-danger">Not Set</span>
                    </template>
                  </h5>
                </div>
                <p class="mb-1">Transaction Date</p>
              </li>
              
              <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 text-light">
                    <template v-if="ticket.sales_rep!=null">
                      {{ticket.sales_rep.name}}
                    </template>
                    <template v-else>
                      <span class="text-danger">Not Set</span>
                    </template>
                  </h5>
                </div>
                <p class="mb-1">Sales Representative</p>
              </li>

              <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 text-light">
                    <template v-if="ticket.cashier!=null">
                      {{ticket.cashier.name}}
                    </template>
                    <template v-else>
                      <span class="text-danger">Not Set</span>
                    </template>
                  </h5>
                </div>
                <p class="mb-1">Cashier Incharge</p>
              </li>
              <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1 text-light">
                    <template v-if="ticket.payment_mode!=null">
                      {{ticket.payment_mode.description}}
                    </template>
                    <template v-else>
                      <span class="text-danger">Not Set</span>
                    </template>
                  </h5>
                </div>
                <p class="mb-1">Payment Mode</p>
              </li>
              <li class="list-group-item list-group-item flex-column align-items-start text-center cursor-pointer bg-light" @click="openCheckOutModal()">
                <strong class="h5 text-uppercase">Check Out</strong>
              </li>
            </div>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
     <!-- START OF ADD PRODUCT MODAL -->
      <b-modal v-model="product_modal" centered size="xl" body-class="p-2" :hide-footer="true" :hide-header="true">
              <add-product-component @addToCart="addToCart"/>
      </b-modal>
      <!-- END OF ADD PRODUCT MODAL -->


      <!-- START OF SALE SETTING MODAL -->
      <b-modal v-model="sale_setting_modal" centered size="md" body-class="p-0" :hide-footer="true" :hide-header="true">
              <sale-setting-component :sale_settings_form="ticket" @settingsSaved="settingsSaved()"/>
      </b-modal>
      <!-- END OF SALE SETTING MODAL -->

      <!-- START OF CHECK OUT MODAL -->
      <b-modal v-model="check_out_modal" centered size="xl" body-class="p-0" :hide-footer="true" :hide-header="true">
              <check-out-component :ticket="ticket" @saleSaved="saleSaved()"/>
      </b-modal>
      <!-- END OF CHECK OUT MODAL -->

      <!-- START OF PAYMENT MODAL -->
      <b-modal v-model="payment_modal" centered size="xl" body-class="p-0" :hide-footer="true" :hide-header="true">
              <payment-component :ticket="ticket" @saleSaved="saleSaved()"/>
      </b-modal>
      <!-- END OF PAYMENT MODAL -->

      <!-- START OF PAYMENT MODAL -->
      <b-modal v-model="transaction_finder_modal" centered size="xl" body-class="p-0" :hide-footer="true" :hide-header="true">
              <transaction-finder />
      </b-modal>
      <!-- END OF PAYMENT MODAL -->
  </div>
</template>
<script>
    import {bus} from '@/main.js';
    import AddProductComponent from './AddProduct.vue';
    import SaleSettingComponent from './SaleSetting.vue';
    import CheckOutComponent from './CheckOut.vue';
    import PaymentComponent from './Payment.vue';
    import TransactionFinder from './TransactionFinder.vue';
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
    import SwalMixin from '@/views/mixins/Swal.js'
    import { payment_modes } from '@/config.js';
    export default {
      mixins:[SwalMixin],
      components: {AddProductComponent,SaleSettingComponent,CheckOutComponent,NumberFormatComponent,PaymentComponent,TransactionFinder},
      data: () => {
          return {
            product_modal:false,
            sale_setting_modal:false,
            check_out_modal:false,
            payment_modal:false,
            transaction_finder_modal:false,
            ticket:{
              ticket_details:[],
              transaction_date:{
                default:''
              }
            },
            loading:false
          }
      },
      computed: {
          total_amount_due(){
              return this.ticket.ticket_details.reduce((total, value)=>{
                      return total + Number(value.total);
                  },0);
          },
      },
      created(){
        this.getTicket();
      },
      methods:{
        getTicket(){
          this.axios.get('sales/ticket/get').then(response => {
              this.ticket = response.data
              if(this.requireSaleSetting())
                this.sale_setting_modal=true;
          }).catch(error => console.log(error));
        },
        settingsSaved(){
          this.getTicket();
          this.sale_setting_modal=false;
        },
        addToCart(product){
          let location_starting_inventory = product.product_details.location_starting_inventories.find(x => x.product_location_id === product.product_location_id);
          let product_unit = product.product_details.product_units.find(x => x.unit_id === product.unit_id);
          let price_type = product.price_type.split('-');
          let data = {
              ticket_id:this.ticket.id,
              authorization_code_designation_id:product.authorization_code_designation_id,
              price_type:product.price_type[0],
              location_starting_inventory_id:location_starting_inventory.id,
              product_location_id:product.product_location_id,
              product_unit_id:product_unit.id,
              base_unit_qty:product_unit.base_unit_qty,
              price_category_id:product.price_category_id,
              price:product.price.value,
              qty:product.qty,
              total:product.qty*product.price.value
          }
          this.axios.post('sales/ticket/add_details',data).then(response => {
                this.product_modal=false;
                this.getTicket();
              
            }).catch(error => {
                
            });
        },
        requireSaleSetting(){
          if(this.ticket.cashier_id===null || this.ticket.payment_mode_id===null || this.ticket.sales_rep_id===null || this.ticket.transaction_date===null)
            return true;
        },
        requireProduct(){
          this.swal_transaction_error_data.text = "No Product Added."
          this.swalRequestError();
        },
        openCheckOutModal(){
          if(this.requireSaleSetting())
            return this.sale_setting_modal=true;

          if(this.ticket.ticket_details.length<=0)
            return this.requireProduct();

          this.check_out_modal=true;
          
        },
        openPaymentModal(){
          if(this.requireSaleSetting())
            return this.sale_setting_modal=true;

          if(this.ticket.payment_mode_id!=payment_modes.CASH && this.ticket.payment_mode_id!=payment_modes.CHECK){
            this.swal_transaction_error_data.text = "Please choose CASH or CHECK as payment method."
            this.swalRequestError();
            return ;
          }

          this.payment_modal=true;
          
        },
        saleSaved(){
          this.check_out_modal=false;
          this.payment_modal=false;
          this.swalTransactionCompleted();
          this.getTicket();
        },
        deleteItem(id){
          this.loading=true;
          this.axios.delete('sales/ticket/delete_details',{ data: {id:id} }).then(response => {
              this.swalTransactionCompleted();
              this.loading=false;
              this.getTicket();
          }).catch(error => {
              this.swal_transaction_error_data.text = error.response.data;
              this.swalRequestError();
              this.loading=false;
          });
        }
      }
    }
</script>
