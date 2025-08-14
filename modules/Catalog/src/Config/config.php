<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Catalog Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Catalog module.
    |
    */

    'name' => 'Catalog',
    'version' => '1.0.0',
    'description' => 'Catalog module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Catalog module.
    |
    */

    'settings' => [
        'enabled' => true,
        'debug' => false,
        'cache' => true,
        'cache_ttl' => 3600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Dependencies
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the dependencies for the Catalog module.
    |
    */

    'dependencies' => [
        // 'Core',
        // 'Auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Permissions
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the permissions for the Catalog module.
    |
    */

    'permissions' => [
        'view' => 'View Catalog',
        'create' => 'Create Catalog',
        'edit' => 'Edit Catalog',
        'delete' => 'Delete Catalog',
    ],
]; 