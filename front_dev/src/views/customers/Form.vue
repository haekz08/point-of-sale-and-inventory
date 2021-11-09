<template>
  <div>
    <b-row align-v="center" class="loader" v-if="is_saving">
        <b-col>
            <b-spinner></b-spinner>
            <br><br>
            <strong>Loading</strong>
        </b-col>
    </b-row>
    <CWidgetIcon
      :header="(typeof form.total_balance != 'undefined') ? form.total_balance.other_formats.format_1 : '0'"
      text="REMAINING BALANCE"
      color="danger"
      class="mb-2"
    >
      <CIcon name="cil-laptop"/>
    </CWidgetIcon>
    <b-form @submit="save">
      <b-form-group
        label="Customer Name:"
        description="This field is required"
      >
        <b-form-input
          v-model="form.name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group
        label="Contact Number:"
      >
        <b-form-input
          v-model="form.contact_number"
          type="text"
        ></b-form-input>
      </b-form-group>
      <b-form-group
        label="Address:"
      >
        <b-form-input
          v-model="form.address"
          type="text"
        ></b-form-input>
      </b-form-group>

      <div class="text-right">
        <router-link to="/maintenance/customers/all">
          <b-button v-if="form.id!=-1" variant="dark" size="sm" class="mr-1">
            <font-awesome-icon icon="chevron-left" /> Back</b-button>
        </router-link>
        <b-button type="submit" variant="dark" size="sm"><font-awesome-icon icon="save" /> Save</b-button>
      </div>
    </b-form>
  </div>
</template>
<script>
    import SwalMixin from '@/views/mixins/Swal.js'
    export default {
      mixins:[SwalMixin],
      data() {
        return {
          form: {
            id:-1,
            name: '',
            contact_number:'',
            address:''
          },
          form_copy:{},
          is_saving:false
        }
      },
      created(){
        this.form_copy=JSON.parse(JSON.stringify(this.form));
        if(this.$route.params.id!=-1)
        this.get();
      },
      methods: {
        get(){
          this.is_saving=true;
          this.axios.get('maintenance/customers/get',{params:{id:this.$route.params.id}}).then(response => {
              this.form=response.data;
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        save(){
          event.preventDefault()
          this.swalConfirmSubmit((data)=>{
              if (data.value) {
                this.is_saving=true;
                this.axios.post('maintenance/customers/save',this.form).then(response => {
                    this.swalTransactionCompleted();
                    this.is_saving=false;
                    if(this.form.id==-1){
                      this.form=JSON.parse(JSON.stringify(this.form_copy));
                    }
                }).catch(error => {
                    this.swal_transaction_error_data.text = error.response.data;
                    this.swalRequestError();
                    this.is_saving=false;
                });
              }
          });
        }
      }
    }
</script>
