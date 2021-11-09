<template>
    <div>
        <div class="card bg-light mb-0">
            <div class="card-header bg-facebook text-white p-2  d-flex justify-content-between align-items-center">
                <div v-if="!loading">
                    <font-awesome-icon icon="database" /><strong>&nbsp;{{list.total}}&nbsp;</strong>
                    <small>Result/s found</small>
                </div>
                <div v-else>
                    <strong>&nbsp;Fetching result...&nbsp;</strong>
                </div>
                <div>
                    <b-button variant="light" size="sm"  @click="modal=true">
                        <font-awesome-icon icon="plus" /> Add
                    </b-button>
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
                    
                    <template v-slot:cell(action)="data">
                        <div class="text-center">
                            <b-button variant="danger" size="sm" @click="deleteRow(data.item.id)" >
                                <font-awesome-icon icon="minus-circle" /> Delete
                            </b-button>
                        </div>
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
        <b-modal v-model="modal" centered size="md" body-class="p-0" :hide-footer="true" :hide-header="true">
            <div class="card bg-light mb-0">
                <div class="card-header bg-facebook text-white p-2">
                    <h6 class="mb-0"><font-awesome-icon icon="plus-circle" /> Add Manual Entry</h6>
                </div>
                <div class="card-body position-relative bg-white p-2">
                    <loader :status="is_saving" />
                    <b-form @submit="save">
                        <b-form-group
                            label="Amount:"
                            description="This field is required"
                        >
                            <b-form-input
                            v-model="form.amount"
                            type="number"
                            step="any"
                            required
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Remarks:"
                        >
                            <b-form-textarea
                                id="textarea"
                                v-model="form.remarks"
                                placeholder="..."
                                rows="3"
                                max-rows="6"
                                required
                            ></b-form-textarea>
                        </b-form-group>

                        <div class="text-right">
                            <b-button type="submit" variant="dark" size="sm"><font-awesome-icon icon="save" /> Save</b-button>
                        </div>
                    </b-form>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {bus} from '@/main.js'
    import SwalMixin from '@/views/mixins/Swal.js'
    import NumberFormatComponent from '@/views/helpers/NumberFormatComponent.vue';
    import Loader from '@/views/helpers/LoaderComponent.vue';
    export default {
        name: 'server-side-paginated-table',
        inheritAttrs: false,
        mixins:[SwalMixin],
        components: {NumberFormatComponent,Loader},
        data(){
            return {
                form:{
                    customer_id:this.$route.params.id,
                    amount:'',
                    remarks:''
                },
                form_copy:{},
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
                    api_url:'maintenance/customers/manual_entries',
                    delete_url:'maintenance/customers/delete_manual_entries',
                    fields:[
                        {key: 'created_at.other_formats.format_1', label:'Transaction Date'},
                        {key: 'remarks', label:'Remarks'},
                        {key: 'amount.other_formats.format_1', label:'Amount'},
                        {key: 'action', label:'Action'},
                    ]
                },
                modal:false,
                is_saving:false
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
            this.form_copy=JSON.parse(JSON.stringify(this.form));
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
                this.axios.get(this.table_settings.api_url + '?customer_id='+this.$route.params.id+'&page=' + this.list.current_page + '&per_page=' + this.selected_display_no + '&search=' + this.search_term).then(response => {
                    let result=response.data;
                    this.list=result
                    this.loading = false;
                    //console.log(result)
                }).catch(error => console.log(error));
            },
            rowDbClicked(item) {
                this.$emit('serverSidePaginatedTableDbClick',item);
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
                        this.axios.delete(this.table_settings.delete_url,{ data: {id:row_id} }).then(response => {
                            this.getAll();
                            this.swal_transaction_completed_data.text="Record successfully deleted.";
                            this.swalTransactionCompleted();
                            this.loading=false;
                            this.getAll()
                        }).catch(error => {
                            this.swalRequestError();
                            this.loading=false;
                        });
                    }
                });
            },
            save(){
                event.preventDefault()
                this.swalConfirmSubmit((data)=>{
                    if (data.value) {
                        this.is_saving=true;
                        this.axios.post('maintenance/customers/add_manual_entries',this.form).then(response => {
                            this.swalTransactionCompleted();
                            this.form=JSON.parse(JSON.stringify(this.form_copy));
                            this.is_saving=false;
                            this.modal=false;
                            this.getAll();
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
