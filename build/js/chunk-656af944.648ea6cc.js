(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-656af944"],{"368f":function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-row",{staticClass:"m-0"},[a("b-col",{staticClass:"p-0",attrs:{sm:"4"}},[a("div",{staticClass:"card bg-light mb-3"},[a("div",{staticClass:"card-header bg-dark text-white"},[a("h6",{staticClass:"mb-0"},[a("font-awesome-icon",{attrs:{icon:"edit"}}),t._v(" Update Record")],1)]),a("div",{staticClass:"card-body position-relative"},[a("form-component",{attrs:{form:t.form}})],1)])])],1)],1)},i=[],s=a("88d8"),o={components:{FormComponent:s["a"]},data:function(){return{form:{id:-1,name:""}}},created:function(){this.form.id=this.$route.params.id},methods:{}},r=o,c=a("2877"),l=Object(c["a"])(r,n,i,!1,null,null,null);e["default"]=l.exports},"73e4":function(t,e,a){"use strict";e["a"]={data:function(){return{swal_confirm_submit_data:{title:"Please confirm your submission.",text:"Your changes will be saved after this process.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, save it!",cancelButtonText:"Wait, im not done yet!"},swal_confirm_delete_data:{title:"Are you sure you want to delete this record?",text:"Note: This action will not be undone.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete!",cancelButtonText:"No, I dont want to delete it!"},swal_transaction_completed_data:{title:"Transaction Completed!",text:"Data Successfully Saved.",icon:"success",showConfirmButton:!1,timer:1e3},swal_transaction_warning_data:{title:"Warning!",text:"Complete all necessary fields!",icon:"warning"},swal_transaction_error_data:{title:"Error!",text:"Please contact your Administrator.",icon:"error"}}},methods:{swalConfirmSubmit:function(t){this.$swal(this.swal_confirm_submit_data).then((function(e){t(e)}))},swalFieldsRequired:function(){this.$swal.fire("Error!","Please fill out all required fields","error")},swalRequestError:function(){this.$swal.fire(this.swal_transaction_error_data)},swalTransactionCompleted:function(){this.$swal.fire(this.swal_transaction_completed_data)},swalConfirmDelete:function(t){this.$swal(this.swal_confirm_delete_data).then((function(e){t(e)}))},swalTransactionWarning:function(){this.$swal.fire(this.swal_transaction_warning_data)}}}},"88d8":function(t,e,a){"use strict";var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.is_saving?a("b-row",{staticClass:"loader",attrs:{"align-v":"center"}},[a("b-col",[a("b-spinner"),a("br"),a("br"),a("strong",[t._v("Loading")])],1)],1):t._e(),a("b-form",{on:{submit:t.save}},[a("b-form-group",{attrs:{label:"Supplier Name:",description:"This field is required"}},[a("b-form-input",{attrs:{type:"text",required:""},model:{value:t.form.name,callback:function(e){t.$set(t.form,"name",e)},expression:"form.name"}})],1),a("div",{staticClass:"text-right"},[a("router-link",{attrs:{to:"/maintenance/suppliers/all"}},[-1!=t.form.id?a("b-button",{staticClass:"mr-1",attrs:{variant:"dark",size:"sm"}},[a("font-awesome-icon",{attrs:{icon:"chevron-left"}}),t._v(" Back")],1):t._e()],1),a("b-button",{attrs:{type:"submit",variant:"dark",size:"sm"}},[a("font-awesome-icon",{attrs:{icon:"save"}}),t._v(" Save")],1)],1)],1)],1)},i=[],s=a("73e4"),o={mixins:[s["a"]],props:{form:{type:Object,default:function(){}}},data:function(){return{form_copy:{},is_saving:!1}},created:function(){this.form_copy=JSON.parse(JSON.stringify(this.form)),-1!=this.form.id&&this.get()},methods:{get:function(){var t=this;this.is_saving=!0,this.axios.get("maintenance/suppliers/get",{params:{id:this.form.id}}).then((function(e){t.form=e.data,t.is_saving=!1})).catch((function(t){return console.log(t)}))},save:function(){var t=this;event.preventDefault(),this.swalConfirmSubmit((function(e){e.value&&(t.is_saving=!0,t.axios.post("maintenance/suppliers/save",t.form).then((function(e){t.swalTransactionCompleted(),t.is_saving=!1,-1==t.form.id&&(t.form=JSON.parse(JSON.stringify(t.form_copy)))})).catch((function(e){t.swalRequestError(),t.is_saving=!1})))}))}}},r=o,c=a("2877"),l=Object(c["a"])(r,n,i,!1,null,null,null);e["a"]=l.exports}}]);
//# sourceMappingURL=chunk-656af944.648ea6cc.js.map