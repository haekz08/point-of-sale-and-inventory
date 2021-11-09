<template>
  <div class="animated fadeIn">
    <server-side-paginated-table
            :fields="table_settings.fields"
            :api_url="table_settings.api_url"
            :delete_url="table_settings.delete_url"
            ref="displayTable"
            @serverSidePaginatedTableDbClick="serverSidePaginatedTableDbClick"
    />
  </div>
</template>
<script>
    import {bus} from '@/main.js';
    import ServerSidePaginatedTable from '@/views/helpers/ServerSidePaginatedTable.vue';
    export default {
      components: {ServerSidePaginatedTable},
      data: () => {
          return {
              table_settings:{
                  api_url:'maintenance/customers/all',
                  delete_url:'maintenance/customers/delete',
                  fields:[
                      {key: 'name', label:'Name'},
                      {key: 'total_balance.other_formats.format_1', label:'Balance'},
                      {key: 'action', label:'Action',class:'text-center'},
                  ]
              },
          }
      },
      created(){
       
      },
      methods:{
        serverSidePaginatedTableDbClick(data){
          this.$router.push('/customers/update/'+data.id);
        }
      }
    }
</script>
