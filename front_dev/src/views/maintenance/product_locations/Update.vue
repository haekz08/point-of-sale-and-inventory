<template>
  <div>
    <b-row class="m-0">
      <b-col sm="4" class="p-0">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="edit" /> Update Record</h6>
          </div>
          <div class="card-body position-relative">
            <form-component :form="form" />
          </div>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
    import FormComponent from './Form.vue';
    export default {
      components: {FormComponent},
      data() {
        return {
          form: {
            id:-1,
            name: '',
            is_default:false
          }
        }
      },
      created(){
        this.form.id=this.$route.params.id;
        //this.get();
      },
      methods: {
          
      }
    }
</script>
