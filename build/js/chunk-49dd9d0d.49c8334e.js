(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-49dd9d0d"],{"05df":function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",[t.is_saving?s("b-row",{staticClass:"loader",attrs:{"align-v":"center"}},[s("b-col",[s("b-spinner"),s("br"),s("br"),s("strong",[t._v("Loading")])],1)],1):t._e(),s("b-row",{staticClass:"m-0"},[s("b-col",{staticClass:"p-0",attrs:{sm:"4"}},[s("div",{staticClass:"card bg-light mb-3"},[s("div",{staticClass:"card-header bg-dark text-white"},[s("h6",{staticClass:"mb-0"},[s("font-awesome-icon",{attrs:{icon:"info-circle"}}),t._v(" Product Details")],1)]),"undefined"!==typeof t.response_data.product?s("div",{staticClass:"card-body bg-white"},[s("b-form-group",{attrs:{label:"Product Name:",description:"This field is required"}},[s("b-form-input",{attrs:{type:"text",disabled:""},model:{value:t.response_data.product.name,callback:function(e){t.$set(t.response_data.product,"name",e)},expression:"response_data.product.name"}})],1),s("b-form-group",{attrs:{label:"Product Code:",description:"This field is required"}},[s("b-form-input",{attrs:{type:"text",disabled:""},model:{value:t.response_data.product.code,callback:function(e){t.$set(t.response_data.product,"code",e)},expression:"response_data.product.code"}})],1),s("b-form-group",{attrs:{label:"Product Brand:",description:"This field is required"}},[s("select",{directives:[{name:"model",rawName:"v-model",value:t.response_data.product.brand_id,expression:"response_data.product.brand_id"}],staticClass:"form-control",attrs:{disabled:""},on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,(function(t){return t.selected})).map((function(t){var e="_value"in t?t._value:t.value;return e}));t.$set(t.response_data.product,"brand_id",e.target.multiple?s:s[0])}}},[s("option",{attrs:{value:""}},[t._v("Please Select")]),t._l(t.response_data.brands,(function(e){return s("option",{domProps:{value:e.id}},[t._v(" "+t._s(e.name)+" ")])}))],2)]),s("b-form-group",{attrs:{label:"Capital Price:",description:"This field is required"}},[s("b-form-input",{attrs:{type:"number",step:"any",disabled:"",placeholder:"0.00"},model:{value:t.response_data.product.capital,callback:function(e){t.$set(t.response_data.product,"capital",e)},expression:"response_data.product.capital"}})],1)],1):t._e()])]),"undefined"!==typeof this.response_data.product?s("b-col",{staticClass:"p-0 pl-3",attrs:{sm:"4"}},[s("div",{staticClass:"card bg-light mb-3"},[s("div",{staticClass:"card-header bg-dark text-white"},[s("h6",{staticClass:"mb-0"},[s("font-awesome-icon",{attrs:{icon:"cubes"}}),t._v(" Product Inventory")],1)]),s("div",{staticClass:"card-body bg-white"},[t.location_starting_inventories.length>0?[s("div",{staticClass:"alert alert-info",attrs:{role:"alert"}},[s("font-awesome-icon",{attrs:{icon:"info-circle"}}),t._v(" This will reset the inventory of the product. ")],1),t._l(t.location_starting_inventories,(function(e,a){return s("fieldset",{staticClass:"border p-3 position-relative"},[s("legend",{staticClass:"w-auto mb-0"},[s("strong",{staticClass:"mx-1 text-uppercase"},[t._v(t._s(e.product_location.name))])]),s("b-row",{staticClass:"border mx-1 mb-3"},[s("b-col",{staticClass:"text-center p-3 bg-info text-white",attrs:{cols:"3"}},[s("h1",[s("font-awesome-icon",{attrs:{icon:"cubes"}})],1)]),s("b-col",{staticClass:"p-3"},[s("h5",{staticClass:"mb-1"},[t._v("Total Remaining")]),s("h4",[s("strong",[t._v(t._s(e.qty)+" "+t._s(t.default_unit.unit.name))])])])],1),s("div",{staticClass:"alert alert-warning d-flex align-items-center",attrs:{role:"alert"}},[s("label",{staticClass:"c-switch c-switch-pill c-switch-success mb-0"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.reset,expression:"location_starting_inventory.reset"}],staticClass:"c-switch-input",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(e.reset)?t._i(e.reset,null)>-1:e.reset},on:{change:function(s){var a=e.reset,i=s.target,n=!!i.checked;if(Array.isArray(a)){var r=null,o=t._i(a,r);i.checked?o<0&&t.$set(e,"reset",a.concat([r])):o>-1&&t.$set(e,"reset",a.slice(0,o).concat(a.slice(o+1)))}else t.$set(e,"reset",n)}}}),s("span",{staticClass:"c-switch-slider"})]),s("span",{staticClass:"ml-1"},[t._v("This will reset the inventory of the product.")])]),t._l(e.product_units,(function(a,i){return s("div",{staticClass:"input-group mb-3"},[s("input",{directives:[{name:"model",rawName:"v-model",value:a.inventory,expression:"product_unit.inventory"}],staticClass:"form-control",attrs:{type:"number",step:"any",placeholder:"0.00",disabled:!e.reset},domProps:{value:a.inventory},on:{input:function(e){e.target.composing||t.$set(a,"inventory",e.target.value)}}}),s("div",{staticClass:"input-group-append"},[s("div",{staticClass:"input-group-text bg-info text-white"},[t._v(" "+t._s(a.unit.name)+" ")])])])}))],2)}))]:t._e(),s("div",{staticClass:"text-right mt-3"},[s("router-link",{attrs:{to:"/products/all"}},[s("b-button",{staticClass:"mr-1",attrs:{variant:"dark",size:"sm"}},[s("font-awesome-icon",{attrs:{icon:"chevron-left"}}),t._v(" Back")],1)],1),s("b-button",{attrs:{variant:"dark",size:"sm"},on:{click:t.resetInventory}},[s("font-awesome-icon",{attrs:{icon:"save"}}),t._v(" Save")],1)],1)],2)])]):t._e()],1)],1)},i=[],n=s("73e4"),r={mixins:[n["a"]],data:function(){return{response_data:{},location_starting_inventories:[],default_unit:{}}},watch:{location_starting_inventories:{handler:function(t){this.location_starting_inventories.forEach((function(t){t.qty=t.product_units.reduce((function(t,e){return t+Number(e.inventory)*Number(e.base_unit_qty)}),0)}))},deep:!0,immediate:!0}},created:function(){this.get(this.$route.params.id)},methods:{get:function(t){var e=this;this.is_saving=!0,this.axios.get("products/get",{params:{id:t}}).then((function(t){e.response_data=t.data,e.default_unit=t.data.product.product_units.find((function(t){return t.is_base_unit}));var s=JSON.parse(JSON.stringify(e.response_data.product.product_units)),a=JSON.parse(JSON.stringify(e.response_data.product.location_starting_inventories));s.forEach((function(t){t.inventory=0})),e.response_data.product_locations.forEach((function(t){var i=a.find((function(e){return e.product_location_id===t.id}));if(i)i.product_units=JSON.parse(JSON.stringify(s)),i.qty=0,i.reset=!1,e.location_starting_inventories.push(i);else{var n={product_id:e.response_data.product.id,product_location_id:t.id,qty:0,id:-1,reset:!1,product_units:JSON.parse(JSON.stringify(s)),product_location:t};e.location_starting_inventories.push(n)}})),e.is_saving=!1})).catch((function(t){return console.log(t)}))},resetInventory:function(){var t=this;this.swalConfirmSubmit((function(e){if(e.value){t.is_saving=!0;var s={location_starting_inventories:t.location_starting_inventories,id:t.response_data.product.id};t.axios.post("products/reset_inventory",s).then((function(e){t.swal_transaction_completed_data.title="Success!",t.swal_transaction_completed_data.text="Successfully setted the product inventory.",t.swalTransactionCompleted(),t.is_saving=!1})).catch((function(e){t.swalRequestError(),t.is_saving=!1}))}}))}}},o=r,c=s("2877"),l=Object(c["a"])(o,a,i,!1,null,null,null);e["default"]=l.exports},"73e4":function(t,e,s){"use strict";e["a"]={data:function(){return{swal_confirm_submit_data:{title:"Please confirm your submission.",text:"Your changes will be saved after this process.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, save it!",cancelButtonText:"Wait, im not done yet!"},swal_confirm_delete_data:{title:"Are you sure you want to delete this record?",text:"Note: This action will not be undone.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Yes, delete!",cancelButtonText:"No, I dont want to delete it!"},swal_transaction_completed_data:{title:"Transaction Completed!",text:"Data Successfully Saved.",icon:"success",showConfirmButton:!1,timer:1e3},swal_transaction_warning_data:{title:"Warning!",text:"Complete all necessary fields!",icon:"warning"},swal_transaction_error_data:{title:"Error!",text:"Please contact your Administrator.",icon:"error"}}},methods:{swalConfirmSubmit:function(t){this.$swal(this.swal_confirm_submit_data).then((function(e){t(e)}))},swalFieldsRequired:function(){this.$swal.fire("Error!","Please fill out all required fields","error")},swalRequestError:function(){this.$swal.fire(this.swal_transaction_error_data)},swalTransactionCompleted:function(){this.$swal.fire(this.swal_transaction_completed_data)},swalConfirmDelete:function(t){this.$swal(this.swal_confirm_delete_data).then((function(e){t(e)}))},swalTransactionWarning:function(){this.$swal.fire(this.swal_transaction_warning_data)}}}}}]);
//# sourceMappingURL=chunk-49dd9d0d.49c8334e.js.map