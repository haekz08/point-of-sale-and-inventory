<template>
  <div>
    <b-row class="m-0">
      <b-col sm="4" class="p-0">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="plus-circle" /> Add New Record</h6>
          </div>
          <div class="card-body">
            <form-component />
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
          
        }
      },
      created(){
        
      },
      methods: {
          
      }
    }
</script>
