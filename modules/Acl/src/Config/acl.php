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
            ]
        ]
    ],

    'Customers' => [
        'View' => [
            'admin.customers.index' => 'Access Customers',
        ]
    ],

    'Meetings' => [
        'View' => [
            'admin.meetings.index' => 'View Meetings',
            'admin.meetings.show' => 'View Meeting Details',
            'admin.meetings.list' => 'View Meetings List',
        ],
        'Create' => [
            'admin.meetings.create' => 'Create Meeting Form',
            'admin.meetings.store' => 'Save Meeting',
            'admin.meetings.new-meeting' => 'Create New Meeting',
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
        ]
    ],

    'Leads' => [
        'View' => [
            'admin.leads.index' => 'View Leads',
            'admin.leads.show' => 'View Lead Details',
            'admin.leads.details' => 'View Lead Details Page',
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
        ],
        'Attachments' => [
            'admin.leads.attachments.store' => 'Add Attachment',
            'admin.leads.attachments.download' => 'Download Attachment',
            'admin.leads.attachments.destroy' => 'Delete Attachment',
        ],
        'Notes' => [
            'admin.leads.notes.store' => 'Add Note',
        ],
        'Application' => [
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
                'admin.whatsapp.templates.bulk-delete' => 'Bulk Delete Templates',
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

    'Settings' => [
        'General' => [
            'View' => [
                'admin.settings.index' => 'View Settings',
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

        'Leads Statuses' => [
            'View' => [
                'admin.settings.statuses.leads.index' => 'View Lead Statuses',
                'admin.settings.statuses.leads.show' => 'View Lead Status Details',
            ],
            'Create' => [
                'admin.settings.statuses.leads.create' => 'Create Lead Status Form',
                'admin.settings.statuses.leads.store' => 'Save Lead Status',
            ],
            'Update' => [
                'admin.settings.statuses.leads.edit' => 'Edit Lead Status Form',
                'admin.settings.statuses.leads.update' => 'Update Lead Status',
            ],
            'Delete' => [
                'admin.settings.statuses.leads.destroy' => 'Delete Lead Status',
                'admin.settings.statuses.leads.bulk-delete' => 'Bulk Delete Lead Statuses',
            ]
        ],
        'Orders Statuses' => [
            'View' => [
                'admin.settings.statuses.orders.index' => 'View Order Statuses',
                'admin.settings.statuses.orders.show' => 'View Order Status Details',
            ],
            'Create' => [
                'admin.settings.statuses.orders.create' => 'Create Order Status Form',
                'admin.settings.statuses.orders.store' => 'Save Order Status',
            ],
            'Update' => [
                'admin.settings.statuses.orders.edit' => 'Edit Order Status Form',
                'admin.settings.statuses.orders.update' => 'Update Order Status',
            ],
            'Delete' => [
                'admin.settings.statuses.orders.destroy' => 'Delete Order Status',
            ]
        ],
        'Tags Statuses' => [
            'View' => [
                'admin.settings.statuses.tags.index' => 'View Tag Statuses',
                'admin.settings.statuses.tags.show' => 'View Tag Status Details',
            ],
            'Create' => [
                'admin.settings.statuses.tags.create' => 'Create Tag Status Form',
                'admin.settings.statuses.tags.store' => 'Save Tag Status',
            ],
            'Update' => [
                'admin.settings.statuses.tags.edit' => 'Edit Tag Status Form',
                'admin.settings.statuses.tags.update' => 'Update Tag Status',
            ],
            'Delete' => [
                'admin.settings.statuses.tags.destroy' => 'Delete Tag Status',
            ]
        ],
        'Source Statuses' => [
            'View' => [
                'admin.settings.statuses.source.index' => 'View Sources',
                'admin.settings.statuses.source.show' => 'View Source Details',
            ],
            'Create' => [
                'admin.settings.statuses.source.create' => 'Create Source Form',
                'admin.settings.statuses.source.store' => 'Save Source',
            ],
            'Update' => [
                'admin.settings.statuses.source.edit' => 'Edit Source Form',
                'admin.settings.statuses.source.update' => 'Update Source',
            ],
            'Delete' => [
                'admin.settings.statuses.source.destroy' => 'Delete Source',
            ]
        ],

        'Countries' => [
            'View' => [
                'admin.settings.countries.leads.index' => 'View Countries',
                'admin.settings.countries.leads.show' => 'View Country Details',
            ],
            'Create' => [
                'admin.settings.countries.leads.create' => 'Create Country Form',
                'admin.settings.countries.leads.store' => 'Save Country',
            ],
            'Update' => [
                'admin.settings.countries.leads.edit' => 'Edit Country Form',
                'admin.settings.countries.leads.update' => 'Update Country',
            ],
            'Delete' => [
                'admin.settings.countries.leads.destroy' => 'Delete Country',
            ]
        ],
        'Currencies' => [
            'View' => [
                'admin.settings.currencies.leads.index' => 'View Currencies',
                'admin.settings.currencies.leads.show' => 'View Currency Details',
            ],
            'Create' => [
                'admin.settings.currencies.leads.create' => 'Create Currency Form',
                'admin.settings.currencies.leads.store' => 'Save Currency',
            ],
            'Update' => [
                'admin.settings.currencies.leads.edit' => 'Edit Currency Form',
                'admin.settings.currencies.leads.update' => 'Update Currency',
            ],
            'Delete' => [
                'admin.settings.currencies.leads.destroy' => 'Delete Currency',
            ]
        ],
        'States' => [
            'View' => [
                'admin.settings.states.leads.index' => 'View States',
                'admin.settings.states.leads.show' => 'View State Details',
            ],
            'Create' => [
                'admin.settings.states.leads.create' => 'Create State Form',
                'admin.settings.states.leads.store' => 'Save State',
            ],
            'Update' => [
                'admin.settings.states.leads.edit' => 'Edit State Form',
                'admin.settings.states.leads.update' => 'Update State',
            ],
            'Delete' => [
                'admin.settings.states.leads.destroy' => 'Delete State',
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
