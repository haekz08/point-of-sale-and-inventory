(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-0794b6ee"],{"685d":function(t,n,e){"use strict";var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",[t.is_saving?e("b-row",{staticClass:"loader",attrs:{"align-v":"center"}},[e("b-col",[e("b-spinner"),e("br"),e("br"),e("strong",[t._v("Loading")])],1)],1):t._e(),e("b-form",{on:{submit:t.save}},[e("b-form-group",{attrs:{label:"Description:",description:"This field is required"}},[e("b-form-input",{attrs:{type:"text",required:""},model:{value:t.form.name,callback:function(n){t.$set(t.form,"name",n)},expression:"form.name"}})],1),e("div",{staticClass:"text-right"},[e("router-link",{attrs:{to:"/maintenance/units/all"}},[-1!=t.form.id?e("b-button",{staticClass:"mr-1",attrs:{variant:"dark",size:"sm"}},[e("font-awesome-icon",{attrs:{icon:"chevron-left"}}),t._v(" Back")],1):t._e()],1),e("b-button",{attrs:{type:"submit",variant:"dark",size:"sm"}},[e("font-awesome-icon",{attrs:{icon:"save"}}),t._v(" Save")],1)],1)],1)],1)},i=[],s=e("73e4"),o={mixins:[s["a"]],props:{form:{type:Object,default:function(){}}},data:function(){return{form_copy:{},is_saving:!1}},created:function(){this.form_copy=JSON.parse(JSON.stringify(this.form)),-1!=this.form.id&&this.get()},methods:{get:function(){var t=this;this.is_saving=!0,this.axios.get("maintenance/units/get",{params:{id:this.form.id}}).then((function(n){t.form=n.data,t.is_saving=!1})).catch((function(t){return console.log(t)}))},save:function(){var t=this;event.preventDefault(),this.swalConfirmSubmit((function(n){n.value&&(t.is_saving=!0,t.axios.post("maintenance/units/save",t.form).then((function(n){t.swalTransactionCompleted(),t.is_saving=!1,-1==t.form.id&&(t.form=JSON.parse(JSON.stringify(t.form_copy)))})).catch((function(n){t.swalRequestError(),t.is_saving=!1})))}))}}},r=o,c=e("2877"),l=Object(c["a"])(r,a,i,!1,null,null,null);n["a"]=l.exports},"73e4":function(t,n,e){"use strict";n["a"]={data:function(){return{swal_confirm_submit_data:{title:"Please confirm your submission.",text:"Your changes will be saved after this process.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, save it!",cancelButtonText:"Wait, im not done yet!"},swal_confirm_delete_data:{title:"Are you sure you want to delete this record?",text:"Note: This action will not be undone.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete!",cancelButtonText:"No, I dont want to delete it!"},swal_transaction_completed_data:{title:"Transaction Completed!",text:"Data Successfully Saved.",icon:"success",showConfirmButton:!1,timer:1e3},swal_transaction_warning_data:{title:"Warning!",text:"Complete all necessary fields!",icon:"warning"},swal_transaction_error_data:{title:"Error!",text:"Please contact your Administrator.",icon:"error"}}},methods:{swalConfirmSubmit:function(t){this.$swal(this.swal_confirm_submit_data).then((function(n){t(n)}))},swalFieldsRequired:function(){this.$swal.fire("Error!","Please fill out all required fields","error")},swalRequestError:function(){this.$swal.fire(this.swal_transaction_error_data)},swalTransactionCompleted:function(){this.$swal.fire(this.swal_transaction_completed_data)},swalConfirmDelete:function(t){this.$swal(this.swal_confirm_delete_data).then((function(n){t(n)}))},swalTransactionWarning:function(){this.$swal.fire(this.swal_transaction_warning_data)}}}},8743:function(t,n,e){"use strict";e.r(n);var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("div",[e("b-row",{staticClass:"m-0"},[e("b-col",{staticClass:"p-0",attrs:{sm:"4"}},[e("div",{staticClass:"card bg-light mb-3"},[e("div",{staticClass:"card-header bg-dark text-white"},[e("h6",{staticClass:"mb-0"},[e("font-awesome-icon",{attrs:{icon:"plus-circle"}}),t._v(" Add New Record")],1)]),e("div",{staticClass:"card-body"},[e("form-component",{attrs:{form:t.form}})],1)])])],1)],1)},i=[],s=e("685d"),o={components:{FormComponent:s["a"]},data:function(){return{form:{id:-1,name:""}}},created:function(){},methods:{}},r=o,c=e("2877"),l=Object(c["a"])(r,a,i,!1,null,null,null);n["default"]=l.exports}}]);
//# sourceMappingURL=chunk-0794b6ee.7a4640b4.js.map