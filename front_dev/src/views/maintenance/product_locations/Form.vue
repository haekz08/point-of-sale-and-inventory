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
      <b-form-group
        label="Warehouse Name:"
        description="This field is required"
      >
        <b-form-input
          v-model="form.name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="is_default" v-model="form.is_default">
        <label class="custom-control-label" for="is_default">Default warehouse for all products?</label>
      </div>

      <div class="text-right">
        <router-link to="/maintenance/warehouses/all">
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
      props:{
          form: {
              type: Object,
              default: () => {}
          }
      },
      data() {
        return {
          form_copy:{},
          is_saving:false
        }
      },
      created(){
        this.form_copy=JSON.parse(JSON.stringify(this.form));
        if(this.form.id!=-1)
        this.get();
      },
      methods: {
        get(){
          this.is_saving=true;
          this.axios.get('maintenance/product_locations/get',{params:{id:this.form.id}}).then(response => {
              this.form=response.data;
              this.is_saving=false;
          }).catch(error => console.log(error));
        },
        save(){
          event.preventDefault()
          this.swalConfirmSubmit((data)=>{
              if (data.value) {
                this.is_saving=true;
                this.axios.post('maintenance/product_locations/save',this.form).then(response => {
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
