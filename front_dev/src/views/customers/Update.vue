<template>
  <div>
    <b-row class="m-0">
      <b-col sm="3" class="p-0">
        <div class="card bg-light mb-3">
          <div class="card-header bg-dark text-white">
              <h6 class="mb-0"><font-awesome-icon icon="edit" /> Update Record</h6>
          </div>
          <div class="card-body position-relative bg-white p-2">
            <form-component />
          </div>
        </div>
      </b-col>
      <b-col class="p-0">
        <div class="bg-white p-2 ml-2 border rounded">
          <b-tabs content-class="mt-2">
            <b-tab title="Charged Transactions" active><charged-transactions /></b-tab>
            <b-tab title="Manual Entries"><manual-entries /></b-tab>
            <b-tab title="Payment Transactions"><payment-transactions /></b-tab>
            <b-tab title="Logs"><transaction-logs /></b-tab>
          </b-tabs>
        </div>
      </b-col>
    </b-row>
  </div>
</template>
<script>
    import FormComponent from './Form.vue';
    import ChargedTransactions from './tabs/ChargedTransactions.vue';
    import ManualEntries from './tabs/ManualEntries.vue';
    import PaymentTransactions from './tabs/PaymentTransactions.vue';
    import TransactionLogs from './tabs/TransactionLogs.vue';
    export default {
      components: {FormComponent,ChargedTransactions,ManualEntries,PaymentTransactions,TransactionLogs},
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
