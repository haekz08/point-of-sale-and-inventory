export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavItem',
        name: 'Dashboard',
        to: '/dashboard',
        icon: 'cil-speedometer'
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Maintenance',
        route: '/maintenance',
        icon: 'cil-settings',
        items: [
          {
            name: 'Units',
            to: '/maintenance/units',
          },
          {
            name: 'Brands',
            to: '/maintenance/brands',
          },
          {
            name: 'Suppliers',
            to: '/maintenance/suppliers',
          },
          {
            name: 'Warehouses',
            to: '/maintenance/warehouses',
          },
          {
            name: 'Price Categories',
            to: '/maintenance/price-categories',
          },
          {
            name: 'Staffs',
            to: '/maintenance/staffs',
          }
        ]
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Products',
        route: '/products',
        icon: 'cil-list',
        items: [
          {
            name: 'View All',
            to: '/products/all',
          },
          {
            name: 'Add New',
            to: '/products/add',
          },
        ]
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Customers',
        route: '/customers',
        icon: 'cil-people',
        items: [
          {
            name: 'View All',
            to: '/customers/all',
          },
          {
            name: 'Add',
            to: '/customers/add',
          }
        ]
      },
      {
        _name: 'CSidebarNavDropdown',
        name: 'Sales',
        route: '/sales',
        icon: 'cil-basket',
        items: [
          {
            name: 'POS',
            to: '/sales/pos',
          },
        ]
      }
    ]
  }
]