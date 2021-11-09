import Vue from 'vue'
import Router from 'vue-router'

// Containers
const LoginContainer = () => import('@/containers/LoginContainer')
const TheContainer = () => import('@/containers/TheContainer')


const Maintenance = () => import('@/views/maintenance/Index')

const Units = () => import('@/views/maintenance/units/Index')
const UnitsAdd = () => import('@/views/maintenance/units/Add')
const UnitsUpdate = () => import('@/views/maintenance/units/Update')
const UnitsAll = () => import('@/views/maintenance/units/All')

const Staffs = () => import('@/views/maintenance/staffs/Index')
const StaffsAdd = () => import('@/views/maintenance/staffs/Add')
const StaffsUpdate = () => import('@/views/maintenance/staffs/Update')
const StaffsAll = () => import('@/views/maintenance/staffs/All')

const Brands = () => import('@/views/maintenance/brands/Index')
const BrandsAdd = () => import('@/views/maintenance/brands/Add')
const BrandsUpdate = () => import('@/views/maintenance/brands/Update')
const BrandsAll = () => import('@/views/maintenance/brands/All')

const Suppliers = () => import('@/views/maintenance/suppliers/Index')
const SuppliersAdd = () => import('@/views/maintenance/suppliers/Add')
const SuppliersUpdate = () => import('@/views/maintenance/suppliers/Update')
const SuppliersAll = () => import('@/views/maintenance/suppliers/All')

const Warehouses = () => import('@/views/maintenance/product_locations/Index')
const WarehousesAdd = () => import('@/views/maintenance/product_locations/Add')
const WarehousesUpdate = () => import('@/views/maintenance/product_locations/Update')
const WarehousesAll = () => import('@/views/maintenance/product_locations/All')

const PriceCategories = () => import('@/views/maintenance/price_categories/Index')
const PriceCategoriesAdd = () => import('@/views/maintenance/price_categories/Add')
const PriceCategoriesUpdate = () => import('@/views/maintenance/price_categories/Update')
const PriceCategoriesAll = () => import('@/views/maintenance/price_categories/All')

const Products = () => import('@/views/products/Index')
const ProductsAdd = () => import('@/views/products/Add')
const ProductsUpdate = () => import('@/views/products/Update')
const ProductsAll = () => import('@/views/products/All')
const ProductsInventory = () => import('@/views/products/Inventory')

const Sales = () => import('@/views/sales/Index')
const SalesPOS = () => import('@/views/sales/Pos')


const Customers = () => import('@/views/customers/Index')
const CustomersAdd = () => import('@/views/customers/Add')
const CustomersUpdate = () => import('@/views/customers/Update')
const CustomersAll = () => import('@/views/customers/All')

Vue.use(Router)

export default new Router({
  mode: 'history', // https://router.vuejs.org/api/#mode
    //base:'/',
  base:'/melford_inventory_v2/build/',
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: configRoutes()
})

function configRoutes () {
  return [
      {
          path: '/login',
          name: 'Login',
          component: LoginContainer
      },
      {
          path: '/',
          redirect: '/maintenance',
          name: 'Home',
          component: TheContainer,
          children: [
            {
                path: '/maintenance',
                redirect: '/maintenance/units',
                name: 'Maintenance',
                component:Maintenance,
                children: [
                    {
                        path: '/maintenance/units',
                        name: 'Units',
                        component: Units,
                        redirect: '/maintenance/units/all',
                        children: [
                            {
                              path: '/maintenance/units/add',
                              name: 'Add',
                              component: UnitsAdd
                            },
                            {
                              path: '/maintenance/units/update/:id',
                              name: 'Update',
                              component: UnitsUpdate
                            },
                            {
                              path: '/maintenance/units/all',
                              name: 'All',
                              component: UnitsAll
                            }
                          ]
                    },
                    {
                      path: '/maintenance/brands',
                      name: 'Brands',
                      component: Brands,
                      redirect: '/maintenance/brands/all',
                      children: [
                          {
                            path: '/maintenance/brands/add',
                            name: 'Add',
                            component: BrandsAdd
                          },
                          {
                            path: '/maintenance/brands/update/:id',
                            name: 'Update',
                            component: BrandsUpdate
                          },
                          {
                            path: '/maintenance/brands/all',
                            name: 'All',
                            component: BrandsAll
                          }
                        ]
                    },
                    {
                      path: '/maintenance/suppliers',
                      name: 'Suppliers',
                      component: Suppliers,
                      redirect: '/maintenance/suppliers/all',
                      children: [
                          {
                            path: '/maintenance/suppliers/add',
                            name: 'Add',
                            component: SuppliersAdd
                          },
                          {
                            path: '/maintenance/suppliers/update/:id',
                            name: 'Update',
                            component: SuppliersUpdate
                          },
                          {
                            path: '/maintenance/suppliers/all',
                            name: 'All',
                            component: SuppliersAll
                          }
                        ]
                    },
                    {
                      path: '/maintenance/warehouses',
                      name: 'Warehouses',
                      component: Warehouses,
                      redirect: '/maintenance/warehouses/all',
                      children: [
                          {
                            path: '/maintenance/warehouses/add',
                            name: 'Add',
                            component: WarehousesAdd
                          },
                          {
                            path: '/maintenance/warehouses/update/:id',
                            name: 'Update',
                            component: WarehousesUpdate
                          },
                          {
                            path: '/maintenance/warehouses/all',
                            name: 'All',
                            component: WarehousesAll
                          }
                        ]
                    },
                    {
                      path: '/maintenance/price-categories',
                      name: 'Price Categories',
                      component: PriceCategories,
                      redirect: '/maintenance/price-categories/all',
                      children: [
                          {
                            path: '/maintenance/price-categories/add',
                            name: 'Add',
                            component: PriceCategoriesAdd
                          },
                          {
                            path: '/maintenance/price-categories/update/:id',
                            name: 'Update',
                            component:PriceCategoriesUpdate
                          },
                          {
                            path: '/maintenance/price-categories/all',
                            name: 'All',
                            component: PriceCategoriesAll
                          }
                        ]
                    },
                    {
                      path: '/maintenance/staffs',
                      name: 'Staffs',
                      component: Staffs,
                      redirect: '/maintenance/staffs/all',
                      children: [
                          {
                            path: '/maintenance/staffs/add',
                            name: 'Add',
                            component: StaffsAdd
                          },
                          {
                            path: '/maintenance/staffs/update/:id',
                            name: 'Update',
                            component: StaffsUpdate
                          },
                          {
                            path: '/maintenance/staffs/all',
                            name: 'All',
                            component: StaffsAll
                          }
                        ]
                    },
                ]
            },
          {
            path: '/products',
            name: 'Products',
            component: Products,
            redirect: '/products/all',
            children: [
                {
                  path: '/products/add',
                  name: 'Add',
                  component: ProductsAdd
                },
                {
                  path: '/products/update/:id',
                  name: 'Update',
                  component: ProductsUpdate
                },
                {
                  path: '/products/all',
                  name: 'All',
                  component: ProductsAll
                },
                {
                  path: '/products/inventory/:id',
                  name: 'Inventory',
                  component: ProductsInventory
                },
              ]
          },
          {
            path: '/sales',
            name: 'Sales',
            component: Sales,
            redirect: '/sales/pos',
            children: [
                {
                  path: '/sales/pos',
                  name: 'POS',
                  component: SalesPOS
                }
              ]
          },
          {
            path: '/customers',
            name: 'Customers',
            component: Customers,
            redirect: '/customers/all',
            children: [
                {
                  path: '/customers/add',
                  name: 'Add',
                  component: CustomersAdd
                },
                {
                  path: '/customers/update/:id',
                  name: 'Update',
                  component: CustomersUpdate
                },
                {
                  path: '/customers/all',
                  name: 'All',
                  component: CustomersAll
                }
              ]
          },
          ]
      },
      
  ]
}

