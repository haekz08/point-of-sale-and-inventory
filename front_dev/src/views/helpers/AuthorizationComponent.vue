<template>
  <div class="p-2 bg-light">
    <b-row class="m-0">
        <b-col cols="3" class="text-center p-2 text-white d-flex align-items-center justify-content-center" v-bind:class="{ 'bg-info': status==1, 'bg-danger': status==2, 'bg-success': status==3 }">
            <font-awesome-icon icon="barcode" class="" style="font-size:72px"/>
        </b-col>
        <b-col class="p-2 bg-white d-flex align-items-center">
            <b-form @submit.prevent="checkAuthorization">
            <div class="w-100">
                <h4 class="mb-2 text-muted">Please Scan the Authorization Card.</h4>
                <input type="password" class="form-control" placeholder="*********************" v-model="form.code" required />
            </div>
            </b-form>
        </b-col>
    </b-row>
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
              code:''
          },
          status:1
        }
      },
      created(){
         
      },
      methods: {
        checkAuthorization(){
            this.axios.post('authorization/check',this.form).then(response => {
                this.status=3;
                this.$emit('authorizationCompleted',response.data);
              
            }).catch(error => {
                this.status=2;
            });
        }
      }
    }
</script>
