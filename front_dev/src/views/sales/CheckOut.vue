<template>
  <div class="p-2 bg-light">
    <b-row align-v="center" class="loader" v-if="loading">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
    <b-form @submit.prevent="save">
    <b-row class="m-0">
        <b-col cols="5" class="p-2 border border-light bg-dark">
            <div class="list-group" style="background-color:#23242d;border-color:#181924;color:#768192!important">
                <li class="list-group-item list-group-item flex-column align-items-start text-center">
                <h2 class="mb-1 text-white" v-if="discount>0">
                    <number-format-component :input_value="total_amount_due"/>
                    <span class="text-danger h4"><del><number-format-component :input_value="sub_total_amount_due"/></del></span>
                </h2>
                <h2 class="mb-1 text-white" v-else>
                    <number-format-component :input_value="total_amount_due"/>
                </h2>
                <p class="mb-1 h4">Total Amount</p>
                </li>
            </div>

            <div class="list-group mt-2" style="background-color:#23242d;border-color:#181924;color:#768192!important">
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{ticket.transaction_date.other_formats.format_1}}</h5>
                </div>
                <p class="mb-1">Transaction Date</p>
                </li>
                
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{ticket.sales_rep.name}}</h5>
                </div>
                <p class="mb-1">Sales Representative</p>
                </li>

                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{ticket.cashier.name}}</h5>
                </div>
                <p class="mb-1">Cashier Incharge</p>
                </li>
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{ticket.payment_mode.description}}</h5>
                </div>
                <p class="mb-1">Payment Mode</p>
                </li>
            </div>
        </b-col>
        <b-col class="px-2">
            <b-row class="m-0 border">
                <b-col cols="1" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="list-ol" class="h2 mb-0" />
                </b-col>
                <b-col class="p-2 bg-white d-flex align-items-center">
                <div class="w-100" v-if="ticket.payment_mode_id==payment_modes.CHARGED">
                    <h6 class="mb-1 text-muted">Charged Order Number</h6>
                    <input type="number" step="any" class="form-control" v-model="charged_number" required/>
                </div>
                <div class="w-100" v-else>
                    <h6 class="mb-1 text-muted">Sales Order Number</h6>
                    <input type="number" step="any" class="form-control" v-model="order_number" required/>
                </div>
                </b-col>
            </b-row>
            <b-row class="m-0 mt-2 border">
                <b-col cols="1" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="user" class="h2 mb-0" />
                </b-col>
                <b-col class="p-2 bg-white d-flex align-items-center">
                <div class="w-100">
                    <h6 class="mb-1 text-muted d-flex w-100 justify-content-between"><span>Customer</span> <a @click.prevent="customer_modal=true" href="#" class="text-info">change</a></h6>
                    <h4>{{(customer.id=='-1' && customer.name=='') ? 'Walk In' : customer.name}}</h4>
                </div>
                </b-col>
            </b-row>
            <!-- <b-row class="m-0 border mt-2">
                <b-col cols="2" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="thumbs-up" class="h2 mb-0" />
                </b-col>
                <b-col class="p-2 bg-white d-flex align-items-center">
                <div class="w-100">
                    <h6 class="mb-1 text-muted">Other Discount</h6>
                    <input type="number" step="any" class="form-control" />
                </div>
                </b-col>
            </b-row> -->
            
            <b-row class="m-0 mt-2" v-if="ticket.payment_mode.require_check_number==1">
                <b-col cols="6" class="p-0 pr-1">
                    <b-row class="m-0 border">
                        <b-col cols="2" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                            <font-awesome-icon icon="thumbs-up" class="h2 mb-0" />
                        </b-col>
                        <b-col class="p-2 bg-white d-flex align-items-center">
                        <div class="w-100">
                            <h6 class="mb-1 text-muted">Other Discount</h6>
                            <input type="number" step="any" class="form-control" v-model="discount"/>
                        </div>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col cols="6" class="p-0 pl-1">
                    <b-row class="m-0 border">
                        <b-col cols="2" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                            <font-awesome-icon icon="check-circle" class="h2 mb-0" />
                        </b-col>
                        <b-col class="p-2 bg-white d-flex align-items-center">
                        <div class="w-100">
                            <h6 class="mb-1 text-muted">Check Number</h6>
                            <input type="number" class="form-control" v-model="check_number" required/>
                        </div>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <b-row class="m-0 border mt-2" v-else>
                <b-col cols="1" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="thumbs-up" class="h2 mb-0" />
                </b-col>
                <b-col class="p-2 bg-white d-flex align-items-center">
                <div class="w-100">
                    <h6 class="mb-1 text-muted">Other Discount</h6>
                    <input type="number" step="any" class="form-control" v-model="discount"/>
                </div>
                </b-col>
            </b-row>
            <b-row class="m-0 border mt-2">
                <b-col cols="1" class="text-center p-2 bg-dark text-white d-flex align-items-center justify-content-center">
                    <font-awesome-icon icon="pencil-alt" class="h2 mb-0" />
                </b-col>
                <b-col class="p-2 bg-white d-flex align-items-center">
                <div class="w-100">
                    <h6 class="mb-1 text-muted">Remarks</h6>
                    <textarea class="form-control" rows="3" placeholder="Optional..." v-model="remarks"></textarea>
                </div>
                </b-col>
            </b-row>

            <b-button type="submit" block variant="success" size="lg" class="mt-2"><font-awesome-icon icon="save" /> Save</b-button>
        </b-col>
    </b-row>
    </b-form>
    <!-- START OF CHECK OUT MODAL -->
      <b-modal v-model="customer_modal" centered size="md" body-class="p-0" :hide-footer="true" :hide-header="true">
              <customer-component @customerSelected="customerSelected" />
      </b-modal>
      <!-- END OF CHECK OUT MODAL -->
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
    import CustomerComponent from '@/views/helpers/CustomerComponent.vue';
    import { payment_modes } from '@/config.js';
    export default {
      mixins:[SwalMixin],
      components:{NumberFormatComponent,CustomerComponent},
      props:{
          ticket: {
              type: Object,
              default: () => {}
          }
      },
      computed: {
          total_amount_due(){
              return this.sub_total_amount_due - this.discount;
          },
          sub_total_amount_due(){
              return this.ticket.ticket_details.reduce((total, value)=>{
                      return total + Number(value.total);
                  },0);
          },
      },
      data() {
        return {
            loading:false,
            customer_modal:false,
            customer:{
                id:-1,
                name:''
            },
            customer_id:'',
            order_number:'',
            charged_number:'',
            discount:0.00,
            check_number:'',
            remarks:'',
            payment_modes:payment_modes
            
        }
      },
      created(){
          console.log(ticket);
      },
      methods: {
        customerSelected(customer){
            this.customer = customer;
            this.customer_id = customer.id;
            this.customer_modal=false;
        },
        save(){
            if(this.ticket.payment_mode_id==payment_modes.CHARGED && this.customer.id==-1)
            {
                this.swal_transaction_error_data.text = 'Please select a customer.';
                this.swalRequestError();
                return;
            }
            this.ticket.customer = this.customer;
            this.ticket.customer_id = this.customer.id;
            this.ticket.order_number = this.order_number;
            this.ticket.charged_number = this.charged_number;
            this.ticket.sub_total = this.sub_total_amount_due;
            this.ticket.discount = this.discount;
            this.ticket.grand_total = this.total_amount_due;
            this.ticket.check_number = this.check_number;
            this.ticket.remarks = this.remarks;

            this.axios.post('sales/save',this.ticket).then(response => {
              this.loading=false
              this.$emit('saleSaved');
            }).catch(error => console.log(error));
        }
      }
    }
</script>
