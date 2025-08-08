<?php
return [
    [
        'label' => 'Dashboard',
        'route' => 'admin.index',
        'icon'  => 'dashboard',
        'permission' => 'admin.index',
    ],
    [
        'label' => 'Customers',
        'route' => 'admin.customers.index',
        'icon'  => 'people',
        'permission' => 'admin.customers.index',
    ],
    [
        'label' => 'Leads',
        'route' => 'admin.leads.index',
        'icon'  => 'leaderboard',
        'permission' => 'admin.leads.index',
    ],
    [
        'label' => 'Whatsapp',
        'route' => 'admin.whatsapp.index',
        'icon'  => 'comment',
        'permission' => 'admin.whatsapp.index',
    ],
    [
        'label' => 'Sales',
        'route' => 'admin.whatsapp.index',
        'icon'  => 'comment',
        'permission' => 'admin.whatsapp.index',
        'children' => [
            [
                'label' => 'Orders',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'article'
            ],
            [
                'label' => 'Transaction',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'article'
            ],
            [
                'label' => 'Invoice',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'article'
            ]
        ]
    ],
    [
        'label' => 'Website',
        'icon'  => 'web', 
        'permission' => null,
        'children' => [
            [
                'label' => 'Coupons',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'article'
            ]
        ]
    ],
    [
        'label' => 'Settings',
        'route' => 'admin.settings.index',
        'icon'  => 'settings',
        'permission' => 'admin.settings.index'
    ],
];
