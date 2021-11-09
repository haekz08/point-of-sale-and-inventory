(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-1688f1f2"],{"73e4":function(t,e,a){"use strict";e["a"]={data:function(){return{swal_confirm_submit_data:{title:"Please confirm your submission.",text:"Your changes will be saved after this process.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, save it!",cancelButtonText:"Wait, im not done yet!"},swal_confirm_delete_data:{title:"Are you sure you want to delete this record?",text:"Note: This action will not be undone.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete!",cancelButtonText:"No, I dont want to delete it!"},swal_transaction_completed_data:{title:"Transaction Completed!",text:"Data Successfully Saved.",icon:"success",showConfirmButton:!1,timer:1e3},swal_transaction_warning_data:{title:"Warning!",text:"Complete all necessary fields!",icon:"warning"},swal_transaction_error_data:{title:"Error!",text:"Please contact your Administrator.",icon:"error"}}},methods:{swalConfirmSubmit:function(t){this.$swal(this.swal_confirm_submit_data).then((function(e){t(e)}))},swalFieldsRequired:function(){this.$swal.fire("Error!","Please fill out all required fields","error")},swalRequestError:function(){this.$swal.fire(this.swal_transaction_error_data)},swalTransactionCompleted:function(){this.$swal.fire(this.swal_transaction_completed_data)},swalConfirmDelete:function(t){this.$swal(this.swal_confirm_delete_data).then((function(e){t(e)}))},swalTransactionWarning:function(){this.$swal.fire(this.swal_transaction_warning_data)}}}},"9f41":function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"animated fadeIn"},[a("server-side-paginated-table",{ref:"displayTable",attrs:{fields:t.table_settings.fields,api_url:t.table_settings.api_url,delete_url:t.table_settings.delete_url}})],1)},i=[],n=a("56d7"),r=a("aa61"),l={components:{ServerSidePaginatedTable:r["a"]},data:function(){return{table_settings:{api_url:"maintenance/suppliers/all",delete_url:"maintenance/suppliers/delete",fields:[{key:"name",label:"Name"},{key:"action",label:"Action",class:"text-center"}]}}},created:function(){var t=this;n["bus"].$on("serverSidePaginatedTableDbClick",(function(e){t.$router.push("/maintenance/suppliers/update/"+e.id)}))}},o=l,c=a("2877"),d=Object(c["a"])(o,s,i,!1,null,null,null);e["default"]=d.exports},aa61:function(t,e,a){"use strict";var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"card bg-light mb-3"},[a("div",{staticClass:"card-header bg-dark text-white"},[a("b-row",[a("b-col",[t.loading?a("div",[a("strong",[t._v(" Fetching result... ")])]):a("div",[a("font-awesome-icon",{attrs:{icon:"database"}}),a("strong",[t._v(" "+t._s(t.list.total)+" ")]),a("small",[t._v("Result/s found")])],1)]),a("b-col",{staticClass:"text-right"},[a("router-link",{attrs:{to:"add"}},[a("b-button",{attrs:{variant:"secondary",size:"sm"}},[a("font-awesome-icon",{attrs:{icon:"plus"}}),t._v(" Add New Record ")],1)],1)],1)],1)],1),a("div",{staticClass:"card-body"},[a("b-row",{staticClass:"mb-3"},[a("b-col",{attrs:{sm:"2"}},[a("b-form-select",{attrs:{options:t.options,size:"sm"},on:{change:t.changeDisplayNo},model:{value:t.selected_display_no,callback:function(e){t.selected_display_no=e},expression:"selected_display_no"}})],1),a("b-col",{attrs:{sm:"6","offset-sm":"4"}},[a("b-input-group",[a("b-input-group-prepend",[a("b-input-group-text",{staticClass:"bg-dark text-white"},[a("font-awesome-icon",{attrs:{icon:"search"}})],1)],1),a("b-form-input",{staticClass:"form-control",attrs:{type:"text",placeholder:"Search",autocomplete:"off",size:"sm"},nativeOn:{keypress:function(e){return t.searching(e)},keyup:function(e){return t.search(e)}},model:{value:t.search_term,callback:function(e){t.search_term=e},expression:"search_term"}}),a("b-input-group-append",[a("b-button",{staticClass:"bg-dark text-white px-4",attrs:{variant:"dark",size:"sm",disabled:""==t.search_term},on:{click:t.clearSearch}},[a("font-awesome-icon",{attrs:{icon:"times"}})],1)],1)],1)],1)],1),a("b-table",{attrs:{selectable:"",selectedVariant:"primary","select-mode":"single",dark:t.dark,hover:t.hover,striped:t.striped,bordered:t.bordered,small:t.small,fixed:t.fixed,responsive:"sm",items:t.table_items,fields:t.captions,busy:t.loading,"show-empty":""},on:{"row-dblclicked":t.rowDbClicked},scopedSlots:t._u([{key:"cell(action)",fn:function(e){return[a("div",{staticClass:"text-center"},[a("b-button",{attrs:{variant:"danger",size:"sm"},on:{click:function(a){return t.deleteRow(e.item.id)}}},[a("i",{staticClass:"fa fa-trash"}),t._v(" Delete ")])],1)]}},{key:"color",fn:function(t){return[a("input",{staticClass:"form-control",attrs:{type:"color",disabled:""},domProps:{value:t.item.color}})]}}])},[a("div",{staticClass:"text-center  my-2",attrs:{slot:"table-busy"},slot:"table-busy"},[a("br"),a("b-spinner",{staticClass:"align-middle",attrs:{small:""}}),a("br"),a("br"),a("strong",[t._v("Loading")])],1)]),t.list.total>0?a("nav",[a("b-pagination",{attrs:{disabled:t.loading,align:"right","total-rows":t.total_rows,"per-page":t.per_page},on:{input:t.getAll},model:{value:t.list.current_page,callback:function(e){t.$set(t.list,"current_page",e)},expression:"list.current_page"}})],1):t._e()],1)])])},i=[],n=a("56d7"),r=a("73e4"),l={name:"server-side-paginated-table",inheritAttrs:!1,mixins:[r["a"]],props:{hover:{type:Boolean,default:!0},striped:{type:Boolean,default:!0},bordered:{type:Boolean,default:!0},small:{type:Boolean,default:!0},fixed:{type:Boolean,default:!0},fields:{type:[Array,Object],default:function(){return[]}},dark:{type:Boolean,default:!1},api_url:{type:String,required:!0},delete_url:{type:String,required:!0},top_right_btn:{type:String,default:"",required:!1}},data:function(){return{selected:[],list:{data:[],from:1,to:0,current_page:1,total:0,per_page:1},result:[],loading:!0,searchTimeout:function(){return{type:Function,default:function(){return{}}}},search_term:"",options:[{value:10,text:"Display 10 records"},{value:25,text:"Display 25 records"},{value:50,text:"Display 50 records"},{value:100,text:"Display 100 records"}],selected_display_no:10}},computed:{table_items:function(){return this.list.data},per_page:function(){return parseInt(this.list.per_page)},total_rows:function(){return parseInt(this.list.total)},captions:function(){return this.fields},total_selected:function(){return parseInt(this.selected.length)}},mounted:function(){this.getAll()},methods:{getAll:function(){var t=this;this.loading=!0,this.axios.get(this.api_url+"?page="+this.list.current_page+"&per_page="+this.selected_display_no+"&search="+this.search_term).then((function(e){var a=e.data;t.list=a,t.loading=!1})).catch((function(t){return console.log(t)}))},clickTopRightBtn:function(){n["bus"].$emit("serverSidePaginatedTableTopRightBtnClicked")},rowDbClicked:function(t){n["bus"].$emit("serverSidePaginatedTableDbClick",t),this.$emit("serverSidePaginatedTableDbClick",t)},searching:function(){this.loading=!0,clearTimeout(this.searchTimeout)},search:function(){var t=this;this.searchTimeout=setTimeout((function(){t.list.current_page=1,t.getAll(),clearTimeout(t.searchTimeout)}),1e3)},clearSearch:function(){this.search_term="",this.getAll()},changeDisplayNo:function(){this.loading=!0,this.list.current_page=1,this.getAll()},deleteRow:function(t){var e=this;this.swalConfirmDelete((function(a){a.value&&(e.loading=!0,e.axios.delete(e.delete_url,{data:{id:t}}).then((function(t){e.getAll(),e.swal_transaction_completed_data.text="Record successfully deleted.",e.swalTransactionCompleted(),e.loading=!1})).catch((function(t){e.swalRequestError(),e.loading=!1})))}))}}},o=l,c=a("2877"),d=Object(c["a"])(o,s,i,!1,null,null,null);e["a"]=d.exports}}]);
//# sourceMappingURL=chunk-1688f1f2.5d00dbf3.js.map