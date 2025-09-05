<?php

return [
    'Dashboard' => [
        'View' => [
            'admin.index' => 'Access Dashboard',
        ]
    ],

    'Catalog' => [
        'Categories' => [
            'View' => [
                'admin.catalog.categories.index' => 'Access Categories',
                'admin.catalog.categories.show' => 'View Category Details',
            ],
            'Create' => [
                'admin.catalog.categories.create' => 'Create Category Form',
                'admin.catalog.categories.store' => 'Save Category',
            ],
            'Update' => [
                'admin.catalog.categories.edit' => 'Edit Category Form',
                'admin.catalog.categories.update' => 'Update Category',
            ],
            'Delete' => [
                'admin.catalog.categories.destroy' => 'Delete Category',
                'admin.catalog.categories.bulk-delete' => 'Bulk Delete Categories',
            ],
            'Import' => [
                'admin.catalog.categories.import_form' => 'View Import Form',
                'admin.catalog.categories.import' => 'Import Categories',
            ],
            'Status' => [
                'admin.catalog.categories.toggle-status' => 'Toggle Category Status',
            ]
        ],
        'Products' => [
            'View' => [
                'admin.catalog.products.index' => 'Access Products',
                'admin.catalog.products.show' => 'View Product Details',
            ],
            'Create' => [
                'admin.catalog.products.create' => 'Create Product Form',
                'admin.catalog.products.store' => 'Save Product',
            ],
            'Update' => [
                'admin.catalog.products.edit' => 'Edit Product Form',
                'admin.catalog.products.update' => 'Update Product',
            ],
            'Delete' => [
                'admin.catalog.products.destroy' => 'Delete Product',
                'admin.catalog.products.bulk-delete' => 'Bulk Delete Products',
            ],
            'Status' => [
                'admin.catalog.products.toggle-status' => 'Toggle Product Status',
                'admin.catalog.products.toggle-featured' => 'Toggle Featured Product',
            ]
        ]
    ],

    'Customers' => [
        'View' => [
            'admin.customers.index' => 'Access Customers',
            'admin.customers.show' => 'View Customer Details',
        ],
        'Create' => [
            'admin.customers.create' => 'Create Customer Form',
            'admin.customers.store' => 'Save Customer',
        ],
        'Update' => [
            'admin.customers.edit' => 'Edit Customer Form',
            'admin.customers.update' => 'Update Customer',
        ],
        'Delete' => [
            'admin.customers.destroy' => 'Delete Customer',
            'admin.customers.bulk-delete' => 'Bulk Delete Customers',
        ],
        'Overview' => [
            'admin.customers.application' => 'View Customer Applications',
            'admin.customers.application.delete' => 'Delete Customer Application',
            'admin.customers.lead' => 'View Customer Leads',
            'admin.customers.orders' => 'View Customer Orders',
            'admin.customers.transactions' => 'View Customer Transactions',
        ]
    ],

    'Discounts' => [
        'View' => [
            'admin.discount.index' => 'Access Discounts',
            'admin.discount.show' => 'View Discount Details',
        ],
        'Create' => [
            'admin.discount.create' => 'Create Discount Form',
            'admin.discount.store' => 'Save Discount'
        ],
        'Update' => [
            'admin.discount.edit' => 'Edit Discount Form',
            'admin.discount.update' => 'Update Discount',
        ],
        'Delete' => [
            'admin.discount.destroy' => 'Delete Discount',
        ],
        'Status' => [
            'admin.discount.toggle-status' => 'Toggle Discount Status',
        ],
        'Validation' => [
            'admin.apply-coupon' => 'Apply Coupon',
            'admin.discount.validate-coupon' => 'Validate Coupon',
        ]
    ],

    'Tax Management' => [
        'Tax' => [
            'View' => [
                'admin.tax.index' => 'Access Tax',
                'admin.tax.show' => 'View Tax Details',
            ],
            'Create' => [
                'admin.tax.create' => 'Create Tax Form',
                'admin.tax.store' => 'Save Tax'
            ],
            'Update' => [
                'admin.tax.edit' => 'Edit Tax Form',
                'admin.tax.update' => 'Update Tax',
            ],
            'Delete' => [
                'admin.tax.destroy' => 'Delete Tax',
            ],
            'Status' => [
                'admin.tax.toggle-status' => 'Toggle Tax Status',
            ]
        ],
        'Tax Categories' => [
            'View' => [
                'admin.tax-category.index' => 'Access Tax Categories',
                'admin.tax-category.show' => 'View Tax Category Details',
            ],
            'Create' => [
                'admin.tax-category.create' => 'Create Tax Category Form',
                'admin.tax-category.store' => 'Save Tax Category'
            ],
            'Update' => [
                'admin.tax-category.edit' => 'Edit Tax Category Form',
                'admin.tax-category.update' => 'Update Tax Category',
            ],
            'Delete' => [
                'admin.tax-category.destroy' => 'Delete Tax Category',
            ]
        ],
        'Tax Rules' => [
            'View' => [
                'admin.tax-rules.index' => 'Access Tax Rules',
                'admin.tax-rules.show' => 'View Tax Rule Details',
            ],
            'Create' => [
                'admin.tax-rules.create' => 'Create Tax Rule Form',
                'admin.tax-rules.store' => 'Save Tax Rule'
            ],
            'Update' => [
                'admin.tax-rules.edit' => 'Edit Tax Rule Form',
                'admin.tax-rules.update' => 'Update Tax Rule',
            ],
            'Delete' => [
                'admin.tax-rules.destroy' => 'Delete Tax Rule',
            ]
        ]
    ],

    'Notifications' => [
        'View' => [
            'admin.notification.index' => 'Access Notifications',
            'admin.notification.show' => 'View Notification Details',
        ],
        'Create' => [
            'admin.notification.create' => 'Create Notification Form',
            'admin.notification.store' => 'Save Notification'
        ],
        'Update' => [
            'admin.notification.edit' => 'Edit Notification Form',
            'admin.notification.update' => 'Update Notification',
        ],
        'Delete' => [
            'admin.notification.destroy' => 'Delete Notification',
        ],
        'Logs' => [
            'View' => [
                'admin.logs.index' => 'Access Logs',
                'admin.logs.show' => 'View Log Details',
            ],
            'Create' => [
                'admin.logs.create' => 'Create Log Form',
                'admin.logs.store' => 'Save Log'
            ],
            'Update' => [
                'admin.logs.edit' => 'Edit Log Form',
                'admin.logs.update' => 'Update Log',
            ],
            'Delete' => [
                'admin.logs.destroy' => 'Delete Log',
            ]
        ]
    ],

    'Meetings' => [
        'View' => [
            'admin.meetings.index' => 'View Meetings',
            'admin.meetings.show' => 'View Meeting Details',
        ],
        'Create' => [
            'admin.meetings.create' => 'Create Meeting Form',
            'admin.meetings.store' => 'Save Meeting',
        ],
        'Update' => [
            'admin.meetings.edit' => 'Edit Meeting Form',
            'admin.meetings.update' => 'Update Meeting',
        ],
        'Delete' => [
            'admin.meetings.destroy' => 'Delete Meeting',
        ],
        'Google Calendar' => [
            'admin.meetings.google.oauth' => 'Google OAuth',
            'admin.meetings.google.callback' => 'Google Callback',
            'admin.meetings.sync' => 'Sync with Google',
            'admin.meetings.share-calander' => 'Share Calendar',
            'admin.meetings.my-meeting' => 'Fetch Meetings',
            'admin.meetings.list' => 'View Meetings List',
            'admin.meetings.new-meeting' => 'Create New Meeting',
        ]
    ],

    'Leads' => [
        'View' => [
            'admin.leads.index' => 'View Leads',
            'admin.leads.show' => 'View Lead Details',
        ],
        'Create' => [
            'admin.leads.create' => 'Create Lead Form',
            'admin.leads.store' => 'Save Lead',
        ],
        'Update' => [
            'admin.leads.edit' => 'Edit Lead Form',
            'admin.leads.update' => 'Update Lead',
            'admin.leads.update-status' => 'Update Lead Status',
            'admin.leads.update-assignment' => 'Update Lead Assignment',
        ],
        'Delete' => [
            'admin.leads.destroy' => 'Delete Lead',
            'admin.leads.bulk-delete' => 'Bulk Delete Leads',
        ],
        'Activities' => [
            'admin.leads.activities.store' => 'Add Lead Activity',
            'admin.leads.getActivitityTabs' => 'Get Activity Tabs',
        ],
        'Attachments' => [
            'admin.leads.attachments.download' => 'Download Attachment',
            'admin.leads.attachments.destroy' => 'Delete Attachment',
        ],
        'Notes' => [
            'admin.leads.notes.store' => 'Add Note',
        ],
        
        'Statuses' => [
            'View' => [
                'admin.statuses.leads.index' => 'View Lead Statuses',
                'admin.statuses.leads.show' => 'View Lead Status Details',
            ],
            'Create' => [
                'admin.statuses.leads.create' => 'Create Lead Status Form',
                'admin.statuses.leads.store' => 'Save Lead Status',
            ],
            'Update' => [
                'admin.statuses.leads.edit' => 'Edit Lead Status Form',
                'admin.statuses.leads.update' => 'Update Lead Status',
            ],
            'Delete' => [
                'admin.statuses.leads.destroy' => 'Delete Lead Status',
            ]
        ],
        'Sources' => [
            'View' => [
                'admin.statuses.source.index' => 'View Sources',
                'admin.statuses.source.show' => 'View Source Details',
            ],
            'Create' => [
                'admin.statuses.source.create' => 'Create Source Form',
                'admin.statuses.source.store' => 'Save Source',
            ],
            'Update' => [
                'admin.statuses.source.edit' => 'Edit Source Form',
                'admin.statuses.source.update' => 'Update Source',
            ],
            'Delete' => [
                'admin.statuses.source.destroy' => 'Delete Source',
            ]
        ],
        'Tags' => [
            'View' => [
                'admin.statuses.tags.index' => 'View Tags',
                'admin.statuses.tags.show' => 'View Tag Details',
            ],
            'Create' => [
                'admin.statuses.tags.create' => 'Create Tag Form',
                'admin.statuses.tags.store' => 'Save Tag',
            ],
            'Update' => [
                'admin.statuses.tags.edit' => 'Edit Tag Form',
                'admin.statuses.tags.update' => 'Update Tag',
            ],
            'Delete' => [
                'admin.statuses.tags.destroy' => 'Delete Tag',
            ]
        ]
    ],

    'Applications' => [
        'View' => [
            'admin.application.index' => 'View Applications',
            'admin.application.show' => 'View Application Details',
        ],
        'Create' => [
            'admin.application.create' => 'Create Application Form',
            'admin.application.store' => 'Save Application',
        ],
        'Update' => [
            'admin.application.edit' => 'Edit Application Form',
            'admin.application.update' => 'Update Application',
        ],
        'Delete' => [
            'admin.application.destroy' => 'Delete Application',
        ],
        'Send' => [
            'admin.application.send_application' => 'Send Application',
        ]
    ],

    'Orders' => [
        'View' => [
            'admin.orders.index' => 'View Orders',
            'admin.orders.show' => 'View Order Details',
        ],
        'Create' => [
            'admin.orders.create' => 'Create Order Form',
            'admin.orders.store' => 'Save Order',
        ],
        'Update' => [
            'admin.orders.edit' => 'Edit Order Form',
            'admin.orders.update' => 'Update Order',
        ],
        'Delete' => [
            'admin.orders.destroy' => 'Delete Order',
            'admin.orders.bulk-delete' => 'Bulk Delete Orders',
        ],
        'Status' => [
            'admin.orders.toggle-status' => 'Toggle Order Status',
        ],
        'Statuses' => [
            'View' => [
                'admin.orders-statuses.index' => 'View Order Statuses',
                'admin.orders-statuses.show' => 'View Order Status Details',
            ],
            'Create' => [
                'admin.orders-statuses.create' => 'Create Order Status Form',
                'admin.orders-statuses.store' => 'Save Order Status',
            ],
            'Update' => [
                'admin.orders-statuses.edit' => 'Edit Order Status Form',
                'admin.orders-statuses.update' => 'Update Order Status',
            ],
            'Delete' => [
                'admin.orders-statuses.destroy' => 'Delete Order Status',
            ]
        ]
    ],

    'Transactions' => [
        'View' => [
            'admin.transactions.index' => 'View Transactions',
            'admin.transactions.show' => 'View Transaction Details',
        ],
        'Create' => [
            'admin.transactions.create' => 'Create Transaction Form',
            'admin.transactions.store' => 'Save Transaction',
        ],
        'Update' => [
            'admin.transactions.edit' => 'Edit Transaction Form',
            'admin.transactions.update' => 'Update Transaction',
        ],
        'Delete' => [
            'admin.transactions.destroy' => 'Delete Transaction',
            'admin.transactions.bulk-delete' => 'Bulk Delete Transactions',
        ],
        'Status' => [
            'admin.transactions.mark-complete' => 'Mark Transaction Complete',
        ]
    ],

    'Invoices' => [
        'View' => [
            'admin.invoice.index' => 'View Invoices',
            'admin.invoice.show' => 'View Invoice Details',
        ],
        'Create' => [
            'admin.invoice.create' => 'Create Invoice Form',
            'admin.invoice.store' => 'Save Invoice',
        ],
        'Update' => [
            'admin.invoice.edit' => 'Edit Invoice Form',
            'admin.invoice.update' => 'Update Invoice',
        ],
        'Delete' => [
            'admin.invoice.destroy' => 'Delete Invoice',
        ]
    ],

    'Payments' => [
        'View' => [
            'admin.payments.index' => 'View Payments',
            'admin.payments.show' => 'View Payment Details',
        ],
        'Create' => [
            'admin.payments.create' => 'Create Payment Form',
            'admin.payments.store' => 'Save Payment',
        ],
        'Update' => [
            'admin.payments.edit' => 'Edit Payment Form',
            'admin.payments.update' => 'Update Payment',
        ],
        'Delete' => [
            'admin.payments.destroy' => 'Delete Payment',
        ],
        'Configuration' => [
            'admin.payments.config' => 'View Payment Configuration',
        ]
    ],

    'WhatsApp' => [
        'View' => [
            'admin.whatsapp.index' => 'Access WhatsApp',
            'admin.whatsapp.templates.index' => 'View Templates',
            'admin.whatsapp.templates.show' => 'View Template Details',
            'admin.whatsapp.compose' => 'Compose Message',
            'admin.whatsapp.message.details' => 'View Message Details',
            'admin.whatsapp.old.index' => 'View Old Messages',
        ],
        'Templates' => [
            'Create' => [
                'admin.whatsapp.templates.create' => 'Create Template Form',
                'admin.whatsapp.templates.store' => 'Save Template',
            ],
            'Update' => [
                'admin.whatsapp.templates.edit' => 'Edit Template Form',
                'admin.whatsapp.templates.update' => 'Update Template',
            ],
            'Delete' => [
                'admin.whatsapp.templates.destroy' => 'Delete Template',
            ],
            'Sync' => [
                'admin.whatsapp.templates.sync' => 'Sync Templates',
            ],
            'Events' => [
                'admin.whatsapp.templates.assign-event' => 'Assign Events',
            ]
        ],
        'Messages' => [
            'Send' => [
                'admin.whatsapp.send.text' => 'Send Text Message',
                'admin.whatsapp.send.template' => 'Send Template Message',
                'admin.whatsapp.send.image' => 'Send Image Message',
            ]
        ]
    ],

    'Email Templates' => [
        'View' => [
            'admin.email-templates.index' => 'View Email Templates',
            'admin.email-templates.show' => 'View Email Template Details',
        ],
        'Create' => [
            'admin.email-templates.create' => 'Create Email Template Form',
            'admin.email-templates.store' => 'Save Email Template',
        ],
        'Update' => [
            'admin.email-templates.edit' => 'Edit Email Template Form',
            'admin.email-templates.update' => 'Update Email Template',
        ],
        'Delete' => [
            'admin.email-templates.destroy' => 'Delete Email Template',
        ]
    ],

    'Pages' => [
        'View' => [
            'admin.pages.index' => 'View Pages',
            'admin.pages.show' => 'View Page Details',
        ],
        'Create' => [
            'admin.pages.create' => 'Create Page Form',
            'admin.pages.store' => 'Save Page',
        ],
        'Update' => [
            'admin.pages.edit' => 'Edit Page Form',
            'admin.pages.update' => 'Update Page',
        ],
        'Delete' => [
            'admin.pages.destroy' => 'Delete Page',
            'admin.pages.bulk-delete' => 'Bulk Delete Pages',
        ],
        'Status' => [
            'admin.pages.toggle-status' => 'Toggle Page Status',
        ]
    ],

    'Widgets' => [
        'View' => [
            'admin.widgets.index' => 'View Widgets',
            'admin.widgets.show' => 'View Widget Details',
        ],
        'Create' => [
            'admin.widgets.create' => 'Create Widget Form',
            'admin.widgets.store' => 'Save Widget',
        ],
        'Update' => [
            'admin.widgets.edit' => 'Edit Widget Form',
            'admin.widgets.update' => 'Update Widget',
        ],
        'Delete' => [
            'admin.widgets.destroy' => 'Delete Widget',
        ],
        'Management' => [
            'admin.widgets.position' => 'Update Widget Position',
            'admin.widgets.sort' => 'Sort Widgets',
            'admin.widgets.assign' => 'Assign Widget',
            'admin.widgets.render' => 'Render Widget',
        ]
    ],

    'File Manager' => [
        'Delete' => [
            'admin.filemanager.delete' => 'Delete File',
        ]
    ],

    'Data Export' => [
        'View' => [
            'admin.import.index' => 'View Data Export',
        ],
        'Export' => [
            'admin.import.export' => 'Export Data',
            'admin.import.preview' => 'Preview Data',
            'admin.import.columns' => 'View Columns',
        ]
    ],

    'Settings' => [
        'General' => [
            'View' => [
                'admin.settings.general.index' => 'View General Settings',
                'admin.settings.general.show' => 'View General Setting Details',
            ],
            'Create' => [
                'admin.settings.general.create' => 'Create General Setting Form',
                'admin.settings.general.store' => 'Save General Setting',
            ],
            'Update' => [
                'admin.settings.general.edit' => 'Edit General Setting Form',
                'admin.settings.general.update' => 'Update General Setting',
            ],
            'Delete' => [
                'admin.settings.general.destroy' => 'Delete General Setting',
            ],
            'Email' => [
                'admin.settings.send.test-mail' => 'Send Test Email',
            ]
        ],
        'Roles' => [
            'View' => [
                'admin.settings.roles.index' => 'View Roles',
                'admin.settings.roles.show' => 'View Role Details',
            ],
            'Create' => [
                'admin.settings.roles.create' => 'Create Role Form',
                'admin.settings.roles.store' => 'Save Role',
            ],
            'Update' => [
                'admin.settings.roles.edit' => 'Edit Role Form',
                'admin.settings.roles.update' => 'Update Role',
            ],
            'Delete' => [
                'admin.settings.roles.destroy' => 'Delete Role',
                'admin.settings.roles.bulk-delete' => 'Bulk Delete Roles',
            ]
        ],
        'Users' => [
            'View' => [
                'admin.settings.users.index' => 'View Users',
                'admin.settings.users.show' => 'View User Details',
            ],
            'Create' => [
                'admin.settings.users.create' => 'Create User Form',
                'admin.settings.users.store' => 'Save User',
            ],
            'Update' => [
                'admin.settings.users.edit' => 'Edit User Form',
                'admin.settings.users.update' => 'Update User',
                'admin.settings.users.toggle-status' => 'Toggle User Status',
            ],
            'Delete' => [
                'admin.settings.users.destroy' => 'Delete User',
                'admin.settings.users.bulk-delete' => 'Bulk Delete Users',
            ]
        ],
        'Countries' => [
            'View' => [
                'admin.settings.countries.index' => 'View Countries',
                'admin.settings.countries.show' => 'View Country Details',
            ],
            'Create' => [
                'admin.settings.countries.create' => 'Create Country Form',
                'admin.settings.countries.store' => 'Save Country',
            ],
            'Update' => [
                'admin.settings.countries.edit' => 'Edit Country Form',
                'admin.settings.countries.update' => 'Update Country',
            ],
            'Delete' => [
                'admin.settings.countries.destroy' => 'Delete Country',
                'admin.settings.countries.bulk-delete' => 'Bulk Delete Countries',
            ]
        ],
        'Currencies' => [
            'View' => [
                'admin.settings.currencies.index' => 'View Currencies',
                'admin.settings.currencies.show' => 'View Currency Details',
            ],
            'Create' => [
                'admin.settings.currencies.create' => 'Create Currency Form',
                'admin.settings.currencies.store' => 'Save Currency',
            ],
            'Update' => [
                'admin.settings.currencies.edit' => 'Edit Currency Form',
                'admin.settings.currencies.update' => 'Update Currency',
            ],
            'Delete' => [
                'admin.settings.currencies.destroy' => 'Delete Currency',
                'admin.settings.currencies.bulk-delete' => 'Bulk Delete Currencies',
            ]
        ],
        'States' => [
            'View' => [
                'admin.settings.states.index' => 'View States',
                'admin.settings.states.show' => 'View State Details',
            ],
            'Create' => [
                'admin.settings.states.create' => 'Create State Form',
                'admin.settings.states.store' => 'Save State',
            ],
            'Update' => [
                'admin.settings.states.edit' => 'Edit State Form',
                'admin.settings.states.update' => 'Update State',
            ],
            'Delete' => [
                'admin.settings.states.destroy' => 'Delete State',
                'admin.settings.states.bulk-delete' => 'Bulk Delete States',
            ]
        ]
    ],

    // 'Authentication' => [
    //     'Login' => [
    //         'admin.login.form' => 'View Login Form',
    //         'admin.login' => 'Login',
    //     ],
    //     'Logout' => [
    //         'admin.logout' => 'Logout',
    //     ]
    // ]
];
