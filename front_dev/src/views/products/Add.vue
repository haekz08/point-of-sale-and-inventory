<template>
  <div>
    <form-component :form="form" />
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
            brand_id:'',
            name: '',
            code: '',
            capital: '',
            default_unit:{
              unit_id:'',
              price:'',
              is_base_unit:true,
              product_unit_prices:[]
            },
            product_units:[],
            supplier_products:[],
          }
        }
      },
      created(){
        
      },
      methods: {
          
      }
    }
</script>
