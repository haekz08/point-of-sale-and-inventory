<template>
    <div>
        <div class="card bg-light mb-0">
            <div class="card-header bg-facebook text-white p-2">
                <div v-if="!loading">
                    <font-awesome-icon icon="database" /><strong>&nbsp;{{list.total}}&nbsp;</strong>
                    <small>Result/s found</small>
                </div>
                <div v-else>
                    <strong>&nbsp;Fetching result...&nbsp;</strong>
                </div>
            </div>
            <div class="card-body bg-light mb-0 p-2">
                <b-row class="mb-2">
                    <b-col sm="4">
                        <b-form-select v-model="selected_display_no" :options="options" size="sm" @change="changeDisplayNo"></b-form-select>
                    </b-col>
                    <b-col sm="6" offset-sm="2">
                        <b-input-group size="sm">
                            <b-input-group-prepend>
                                <b-input-group-text class="bg-dark text-white"><font-awesome-icon icon="search" /></b-input-group-text>
                            </b-input-group-prepend>
                            <b-form-input v-model="search_term" type="text" debounce="500" placeholder="Search..." autocomplete="off"></b-form-input>
                            <b-input-group-append>
                              <b-button @click="clearSearch" variant="dark" class="bg-dark text-white" :disabled="search_term==''">
                                  <font-awesome-icon icon="times" />
                              </b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-col>
                </b-row>
                
                <b-table
                        selectable
                        selectedVariant="info"
                        select-mode="single"
                        responsive="sm"
                        small
                        :items="table_items"
                        :fields="captions"
                        :busy="loading"
                        bordered
                        show-empty
                        @row-dblclicked="rowDbClicked"
                        head-variant="dark"
                        class="bg-white"
                >
                    <div class="text-center my-2" slot="table-busy">
                        <br>
                        <b-spinner small class="align-middle"></b-spinner>
                        <br><br>
                        <strong>Loading</strong>
                    </div>
                    
                    <template v-slot:cell(payment_mode_col)="data">
                        <h6 class="mb-0">{{(data.item.order_number==null) ? data.item.charged_number : data.item.order_number}}</h6>
                        <small>{{data.item.payment_mode.description}}</small>
                    </template>
                    <template v-slot:cell(customer_col)="data">
                        {{(data.item.customer==null) ? 'WALK IN' : data.item.customer.name}}
                    </template>
                </b-table>
                <nav v-if="list.total>0">
                    <b-pagination
                            :disabled="loading"
                            @input="getAll"
                            align="right"
                            :total-rows="total_rows"
                            :per-page="per_page"
                            v-model="list.current_page"
                            class="mb-0"
                    >
                    </b-pagination>
                </nav>
            </div>
        </div>
        <b-modal v-model="modal" centered size="xl" body-class="p-0" :hide-footer="true" :hide-header="true">
            <sales :sale_id="selected_sale_id" />
        </b-modal>
    </div>
</template>

<script>
    import {bus} from '@/main.js'
    import SwalMixin from '@/views/mixins/Swal.js'
    import Sales from './Sales.vue';
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
    export default {
        name: 'server-side-paginated-table',
        inheritAttrs: false,
        mixins:[SwalMixin],
        components: {NumberFormatComponent,Sales},
        data(){
            return {
                selected: [],
                list: {
                    data: [],
                    from: 1,
                    to: 0,
                    current_page: 1,
                    total: 0,
                    per_page: 1,
                },
                result:[],
                loading: true,
                modal: false,
                selected_sale_id:-1,
                searchTimeout: () => ({
                    type: Function,
                    default: () => ({})
                }),
                search_term: '',
                options: [
                    { value: 10, text: 'Display 10 records' },
                    { value: 25, text: 'Display 25 records' },
                    { value: 50, text: 'Display 50 records' },
                    { value: 100, text: 'Display 100 records' }
                ],
                selected_display_no:10,
                table_settings:{
                    api_url:'sales/all',
                    delete_url:'daily_logs/delete',
                    fields:[
                        {key: 'transaction_date.other_formats.format_1', label:'Transaction Date'},
                        {key: 'payment_mode_col', label:'Payment Mode'},
                        {key: 'customer_col', label:'Customer'},
                        {key: 'sub_total.other_formats.format_1', label:'Sub Total'},
                        {key: 'discount.other_formats.format_1', label:'Discount'},
                        {key: 'grand_total.other_formats.format_1', label:'Grand Total'},
                    ]
                }
            }
        },
        computed: {
            table_items: function () {
                return this.list.data;
            },
            per_page: function () {
                return parseInt(this.list.per_page);
            },
            total_rows: function () {
                return parseInt(this.list.total);
            },
            captions: function () {
                return this.table_settings.fields
            },
            total_selected: function () {
                return parseInt(this.selected.length);
            }
        },
        created(){
        },
        mounted() {
            //this.getAll();
        },
        watch: {
            search_term:{
                immediate: true,
                handler(){
                    if(this.search_term!='')
                    this.loading = true;
                    this.list.current_page=1;
                    this.getAll();
                }
            },
            project_location_structure_item_id:{
                immediate: true,
                handler(){
                    
                    if(this.project_location_structure_item_id!=-1 && this.project_location_structure_item_id!=''){
                        this.loading = true;
                        this.list.current_page=1;
                        this.getAll();
                        //alert(1);
                    }
                }
            }
        },
        methods: {
            getAll() {
                this.loading = true;
                this.axios.get(this.table_settings.api_url + '?page=' + this.list.current_page + '&per_page=' + this.selected_display_no + '&search=' + this.search_term).then(response => {
                    let result=response.data;
                    this.list=result
                    this.loading = false;
                    //console.log(result)
                }).catch(error => console.log(error));
            },
            clickTopRightBtn() {
                //this.$emit('openModal',this.selected);
                this.$emit('serverSidePaginatedTableTopRightBtnClicked');
            },
            rowDbClicked(item) {
                this.selected_sale_id = item.id;
                this.modal=true;
            },
            clearSearch(){
                this.search_term=''
                this.getAll();
            },
            changeDisplayNo(){
                this.loading = true;
                this.list.current_page=1;
                this.getAll();
            },
            deleteRow(row_id){
                this.swalConfirmDelete((data)=>{
                    if (data.value) {
                        this.loading=true;
                        this.axios.delete(this.delete_url,{ data: {id:row_id} }).then(response => {
                            this.getAll();
                            this.swal_transaction_completed_data.text="Record successfully deleted.";
                            this.swalTransactionCompleted();
                            this.loading=false;
                            bus.$emit('refreshComputations');
                        }).catch(error => {
                            this.swalRequestError();
                            this.loading=false;
                        });
                    }
                });
            }
        }
    }
</script>
