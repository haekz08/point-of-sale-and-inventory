<template>
  <div class="p-2 bg-light">
    <b-row align-v="center" class="loader" v-if="loading">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
    <b-row class="m-0" v-if="typeof sale.id!='undefined'">
        <b-col cols="5" class="p-2 border border-light bg-dark">
            <div class="list-group" style="background-color:#23242d;border-color:#181924;color:#768192!important">
                <li class="list-group-item list-group-item flex-column align-items-start text-center">
                <h2 class="mb-1 text-white" v-if="sale.discount.default>0">
                    <number-format-component :input_value="sale.grand_total.default"/>
                    <span class="text-danger h4"><del><number-format-component :input_value="Number(sale.sub_total.default)"/></del></span>
                </h2>
                <h2 class="mb-1 text-white" v-else>
                    <number-format-component :input_value="Number(sale.grand_total.default)"/>
                </h2>
                <p class="mb-1 h4">Total Amount</p>
                </li>
            </div>

            <div class="list-group mt-2" style="background-color:#23242d;border-color:#181924;color:#768192!important">
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{sale.transaction_date.other_formats.format_1}}</h5>
                </div>
                <p class="mb-1">Transaction Date</p>
                </li>
                
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{sale.sales_rep.name}}</h5>
                </div>
                <p class="mb-1">Sales Representative</p>
                </li>

                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{sale.cashier.name}}</h5>
                </div>
                <p class="mb-1">Cashier Incharge</p>
                </li>
                <li class="list-group-item list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 text-light">{{sale.payment_mode.description}}</h5>
                </div>
                <p class="mb-1">Payment Mode</p>
                </li>
            </div>
        </b-col>
        <b-col class="p-2 bg-white">
            <b-button-group class="mb-2" v-if="!sale.is_deleted">
                <b-button variant="danger" @click="voidTransaction(sale.id)"><font-awesome-icon icon="times-circle" /> Void this Transaction</b-button>
                <b-button variant="light" @click="returnSubmit()"><font-awesome-icon icon="list" /> Process Return of Product/s</b-button>
            </b-button-group>
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
                <tr v-for="(sale_detail, index) in sale.sale_details">
                    <th scope="row" class="text-center">{{index+1}}</th>
                    <td>{{sale_detail.product_unit.product.name}}</td>
                    <td align="center"><number-format-component :input_value="sale_detail.qty" :currency="false"/> {{sale_detail.product_unit.unit.name}}</td>
                    <td align="center"><span class="amount-100"><number-format-component :input_value="Number(sale_detail.price)"/></span></td>
                    <td align="center"><span class="amount-100"><strong><number-format-component :input_value="Number(sale_detail.total)"/></strong></span></td>
                    <td align="center"><font-awesome-icon icon="reply" class="h5 text-info mb-0 cursor-pointer" @click="returnItem(sale_detail)"/></td>
                </tr>
                </tbody>
            </table>
        </b-col>
    </b-row>
    <b-modal v-model="return_modal" centered size="md" body-class="p-0" :hide-footer="true" :hide-header="true">
        <div class="card bg-light mb-0">
          <div class="card-header bg-dark text-white p-2">
              <h6 class="mb-0"><font-awesome-icon icon="reply" /> Return</h6>
          </div>
          <div class="card-body p-2">
            <b-form @submit.prevent="returnOk">
                <b-form-group
                    label="Returned Qty:"
                    description="This field is required"
                >
                    <b-input-group size="sm" :append="(typeof selected_sale_detail.product_unit != 'undefined' ? selected_sale_detail.product_unit.unit.name : '')">
                        <b-form-input
                        v-model="selected_sale_detail.sale_return_detail.qty"
                        type="number"
                        step="any"
                        :max="selected_sale_detail.sale_return_detail.qty"
                        required
                        ></b-form-input>
                    </b-input-group>
                </b-form-group>
                <b-form-group
                    label="Returned To:"
                    description="This field is required"
                >
                    <select class="form-control form-control-sm" v-model="selected_sale_detail.sale_return_detail.product_location_id">
                        <option value="">Please Select</option>
                        <option v-for="product_location in product_locations" :value="product_location.id">
                            {{product_location.name}}
                        </option>
                    </select>
                </b-form-group>
                <div class="text-right w-100">
                      <b-button type="submit"> Ok</b-button>
                  </div>
            </b-form>
          </div>
        </div>
    </b-modal>
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
    export default {
      mixins:[SwalMixin],
      components:{NumberFormatComponent},
      props:{
          sale_id: {
              type: Number,
          }
      },
      data() {
        return {
            loading:false,
            product_locations:[],
            sale:{},
            selected_sale_detail:{
                sale_return_detail:{
                    qty:0,
                    product_location_id:'',

                }
            },
            return_modal:false
        }
      },
      created(){
          this.get();
      },
      methods: {
        get(){
          this.is_saving=true;
          this.axios.get('sales/get',{params:{id:this.sale_id}}).then(response => {
              this.sale=response.data.sale;
              this.product_locations = response.data.product_locations;
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        voidTransaction(id){
            this.swal_confirm_delete_data.confirmButtonText = 'Yes, Void this transaction!';
            this.swalConfirmDelete((data)=>{
                if (data.value) {
                    this.axios.delete('sales/delete',{ data: {id:id} }).then(response => {
                        this.swalTransactionCompleted();
                        this.get();
                    }).catch(error => {
                        this.swal_transaction_error_data.text = error.response.data;
                        this.swalRequestError();
                        this.loading=false;
                    });
                }
            });
        },
        returnItem(sale_detail){
            let data = JSON.parse(JSON.stringify(sale_detail));
            if(data.sale_return_detail==null){
                let sale_return_detail = {
                    qty:sale_detail.qty,
                    product_location_id:sale_detail.product_location_id
                }
                data.sale_return_detail = sale_return_detail;
            }
            this.selected_sale_detail=data;
            this.return_modal=true;
        },
        returnOk(){
            console.log(this.selected_sale_detail);
            this.return_modal = false;
            let data = this.sale.sale_details.find(x => x.id === this.selected_sale_detail.id);
            data.sale_return_detail = this.selected_sale_detail.sale_return_detail;
            this.selected_sale_detail={
                sale_return_detail:{
                    qty:0,
                    product_location_id:''
                }
            };
        },
        returnSubmit(){
            this.swal_confirm_submit_data.confirmButtonText = 'Yes, Return Products!';
            this.swalConfirmSubmit((data)=>{
                if (data.value) {
                    this.axios.post('sales/return',this.sale).then(response => {
                        this.swalTransactionCompleted();
                        this.get();
                    }).catch(error => {
                        this.swal_transaction_error_data.text = error.response.data;
                        this.swalRequestError();
                        this.loading=false;
                    });
                }
            });
        },
      }
    }
</script>
