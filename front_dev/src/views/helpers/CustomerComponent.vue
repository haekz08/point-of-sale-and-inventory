<template>
  <div class="p-2 bg-dark">
    <b-row class="m-0 border">
        <b-col cols="2" class="text-center p-2 bg-info text-white d-flex align-items-center justify-content-center">
            <font-awesome-icon icon="user" class="h2 mb-0" />
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
        <div class="w-100">
            <h6 class="mb-1 text-muted d-flex w-100 justify-content-between"><span>Customer Search</span></h6>
            
            <b-input-group>
                <template v-slot:append>
                    <b-button variant="info" @click="newCustomer">New Customer</b-button>
                </template>
                <b-form-input v-model="keyword" type="text" debounce="500" placeholder="Type Something..." autocomplete="off"></b-form-input>
            </b-input-group>
        </div>
        </b-col>
    </b-row>
    <div style="min-height:500px;max-height:500px;overflow-y:auto" class="bg-white mt-2 p-2">
        <b-list-group v-if="customers.length>0">
            <b-list-group-item button v-for="customer in customers" @click="selected(customer)">{{customer.name}}</b-list-group-item>
        </b-list-group>
    </div>
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
      watch: {
        keyword:{
            immediate: true,
            handler(){
                if(this.keyword!='')
                this.search();
            }
        }
      },
      data() {
        return {
            loading:false,
            keyword:'',
            customers:[]
        }
      },
      created(){

      },
      methods: {
        search(){
            this.loading = true;
            this.axios.get('/maintenance/customers/all?search=' + this.keyword).then(response => {
                this.customers=response.data;
                this.loading = false;
                //console.log(result)
            }).catch(error => console.log(error));
        },
        newCustomer(){
            if(this.keyword=='')
            return this.swalFieldsRequired();

            let form={id:-1,name:this.keyword};
            this.loading = true;
            this.axios.post('/maintenance/customers/save' ,form).then(response => {
                let customer=response.data;
                this.loading = false;
                this.selected(customer);
            }).catch(error => {
                this.swal_transaction_error_data.text = error.response.data;
                this.swalRequestError();
                this.is_saving=false;
            });

        },
        selected(customer){
            this.$emit('customerSelected',customer);
        }
      }
    }
</script>
