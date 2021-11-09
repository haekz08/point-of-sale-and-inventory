<template>
  <div class="animated fadeIn">
    <server-side-paginated-table
            :fields="table_settings.fields"
            :api_url="table_settings.api_url"
            :delete_url="table_settings.delete_url"
            ref="displayTable"
    />
  </div>
</template>
<script>
    import {bus} from '@/main.js';
    import ServerSidePaginatedTable from './ProductsTable.vue';
    export default {
      components: {ServerSidePaginatedTable},
      data: () => {
          return {
              table_settings:{
                  api_url:'products/all',
                  delete_url:'products/delete',
                  fields:[
                      {key: 'name', label:'Name'},
                      {key: 'action', label:'Action',class:'text-center'},
                  ]
              },
          }
      },
      created(){
        bus.$on('serverSidePaginatedTableDbClick', (data)=>{
            this.$router.push('/products/update/'+data.id);
        });
      }
    }
</script>
