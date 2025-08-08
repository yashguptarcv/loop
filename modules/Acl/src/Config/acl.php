<?php

return [
    'dashboard' => [
        'admin.index' => 'Access Dashboard',
    ],

    'customers' => [
        'admin.customers.index' => 'Access Customer',
    ],

    'leads' => [
        'admin.leads.index'            => 'Access Leads',
        'admin.leads.details'          => 'View Lead Details',
        'admin.leads.create'           => 'Create new leads',
        'admin.leads.store'            => 'Save leads data',
        'admin.leads.edit'             => 'Lead edit form',
        'admin.leads.update'           => 'Lead epdate data',
        'admin.leads.destroy'          => 'Delete leads',
        'admin.leads.update-status'    => 'Change lead status',
        'admin.leads.bulk-delete'      => 'Delete bulk leads',
    ],

    'whatsapp' => [    
        'index'     => [
            'admin.whatsapp.index'              => 'Access Whatsapp'
        ],

        'Template Create' => [
            'admin.whatsapp.templates.create'   => 'View Template Form',
            'admin.whatsapp.templates.store'    => 'Save Template',
            'admin.whatsapp.templates.edit'     => 'Edit Template Form',
            'admin.whatsapp.templates.update'   => 'Update Template',
        ],

        'Delete' => [
            'admin.whatsapp.templates.destroy'  => 'Delete Template',
        ],

        'Sync' => [
            'admin.whatsapp.templates.sync'     => 'Sync templates',
        ]
    ],

    'settings' => [
        'index' => [
            'admin.settings.index' => 'View Settings',
        ],

        'roles' => [
            'admin.settings.roles.index'    => 'View Roles',
            'admin.settings.roles.create'   => 'Create Roles',
            'admin.settings.roles.store'    => 'Store Roles',
            'admin.settings.roles.edit'     => 'Edit Roles',
            'admin.settings.roles.update'   => 'Update Roles',
            'admin.settings.roles.destroy'  => 'Delete Roles',
            'admin.settings.roles.bulk-delete' => 'Delete Bulk Roles',
        ],

        'users' => [
            'admin.settings.users.index'            => 'View Users',
            'admin.settings.users.create'           => 'Create Users',
            'admin.settings.users.store'            => 'Store Users',
            'admin.settings.users.edit'             => 'Edit Users',
            'admin.settings.users.update'           => 'Update Users',
            'admin.settings.users.destroy'          => 'Delete Users',
            'admin.settings.users.toggle-status'    => 'Change Users Status',
            'admin.settings.users.bulk-delete'      => 'Delete Bulk Users',
        ],

        'statuses' => [
            'admin.settings.statuses.leads.index'            => 'Leads Statuses',
            'admin.settings.statuses.leads.create'           => 'Leads Create Statuses',
            'admin.settings.statuses.leads.store'            => 'Leads Store Statuses',
            'admin.settings.statuses.leads.edit'             => 'Leads Edit Statuses',
            'admin.settings.statuses.leads.update'           => 'Leads Update Statuses',
            'admin.settings.statuses.leads.destroy'          => 'Leads Delete Statuses',
            'admin.settings.statuses.leads.toggle-status'    => 'Leads Change Statuses Status',
            'admin.settings.statuses.leads.bulk-delete'      => 'Leads Delete Bulk Statuses'
        ],
    ],
];
