<?php
return [
    [
        'label' => 'Dashboard',
        'route' => 'admin.index',
        'icon'  => 'dashboard',
        'permission' => 'admin.index',
    ],
    [
        'label' => 'Catalog',
        'route' => '#',
        'icon'  => 'blur_linear',
        'permission' => 'admin.whatsapp.index',
        'children' => [
            [
                'label' => 'Categories',
                'route' => 'admin.catalog.categories.index',
                'permission' => 'admin.catalog.categories.index',
                'icon' => 'chevron_right'
            ],

            [
                'label' => 'Products',
                'route' => 'admin.catalog.products.index',
                'permission' => 'admin.catalog.products.index',
                'icon' => 'chevron_right'
            ]
        ]
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
        'label' => 'Meetings',
        'route' => 'admin.meetings.index',
        'icon'  => 'event',
        'permission' => 'admin.meetings.index',
    ],
    [
        'label' => 'Whatsapp',
        'route' => 'admin.whatsapp.index',
        'icon'  => 'comment',
        'permission' => 'admin.whatsapp.index',
    ],
    [
        'label' => 'Sales',
        'route' => 'admin.settings.index',
        'icon'  => 'trending_up',
        'permission' => 'admin.settings.index',
        'children' => [
            [
                'label' => 'Orders',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'chevron_right'
            ],
            [
                'label' => 'Transaction',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'chevron_right'
            ],
            [
                'label' => 'Invoice',
                'route' => 'admin.settings.index',
                'permission' => 'admin.website.cms.index',
                'icon' => 'chevron_right'
            ]
        ]
    ],
    [
        'label' => 'Website',
        'icon'  => 'web', 
        'permission' => '#',
        'children' => [
            [
                'label' => 'Coupons',
                'route' => 'admin.coupons.index',
                'permission' => 'admin.coupons.index',
                'icon' => 'chevron_right'
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
