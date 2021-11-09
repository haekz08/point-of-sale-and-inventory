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
        <b-col cols="2" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="calendar" class="h2 mb-0" />
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
        <div class="w-100">
            <h6 class="mb-1 text-muted">Transaction Date</h6>
            <input type="date" class="form-control" v-model="form.transaction_date.default" required/>
        </div>
        </b-col>
    </b-row>

    <b-row class="m-0 mt-2">
        <b-col cols="2" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="tag" class="h2 mb-0" />
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
        <div class="w-100">
            <h6 class="mb-1 text-muted">Payment Mode</h6>
            <select class="form-control" v-model="form.payment_mode_id" required>
                <option value="">Please Select</option>
                <option v-for="payment_mode in fields.payment_modes" :value="payment_mode.id">
                    {{payment_mode.description}}
                </option>
            </select>
        </div>
        </b-col>
    </b-row>

    <b-row class="m-0 mt-2">
        <b-col cols="2" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="users" class="h2 mb-0" />
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
        <div class="w-100">
            <h6 class="mb-1 text-muted">Sales Representative</h6>
            <select class="form-control" v-model="form.sales_rep_id" required>
                <option value="">Please Select</option>
                <option v-for="staff in fields.staffs" :value="staff.id">
                    {{staff.name}}
                </option>
            </select>
        </div>
        </b-col>
    </b-row>

    <b-row class="m-0 mt-2">
        <b-col cols="2" class="text-center p-2 bg-warning text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="users" class="h2 mb-0" />
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
        <div class="w-100">
            <h6 class="mb-1 text-muted">Cashier Incharge</h6>
            <select class="form-control" v-model="form.cashier_id" required>
                <option value="">Please Select</option>
                <option v-for="staff in fields.staffs" :value="staff.id">
                    {{staff.name}}
                </option>
            </select>
        </div>
        </b-col>
    </b-row>

    <b-button type="submit" block variant="success" size="lg" class="mt-2"><font-awesome-icon icon="save" /> Save</b-button>
    </b-form>
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
      props:{
          sale_settings_form: {
              type: Object,
              default: () => {}
          }
      },
      data() {
        return {
          loading:false,
          form:{
              cashier_id:'',
              payment_mode_id:'',
              sales_rep_id:'',
              transaction_date:''
          },
          fields:{
              payment_modes:[],
              staffs:[]
          }
        }
      },
      created(){
        this.getFields();
        this.setForm();
      },
      methods: {
        setForm() {
            if(this.sale_settings_form.cashier_id!==null)
                this.form.cashier_id=this.sale_settings_form.cashier_id;
            if(this.sale_settings_form.payment_mode_id!==null)
                this.form.payment_mode_id=this.sale_settings_form.payment_mode_id;
            if(this.sale_settings_form.sales_rep_id!==null)
                this.form.sales_rep_id=this.sale_settings_form.sales_rep_id;
            if(this.sale_settings_form.transaction_date!==null)
                this.form.transaction_date=this.sale_settings_form.transaction_date;
        },
        getFields(){
            this.loading=true;
            this.axios.get('sales/settings').then(response => {
              this.fields = response.data;
              this.loading=false;
            }).catch(error => console.log(error));
        },
        save(){
            this.loading=true;
            this.form.transaction_date = this.form.transaction_date.default;
            this.axios.post('sales/ticket/save',this.form).then(response => {
              this.loading=false
              this.swalTransactionCompleted();
              this.$emit('settingsSaved');
            }).catch(error => console.log(error));
        }
      }
    }
</script>
