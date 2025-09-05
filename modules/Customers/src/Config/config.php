<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Customers Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Customers module.
    |
    */

    'name' => 'Customers',
    'version' => '1.0.0',
    'description' => 'Customers module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Customers module.
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
    | Here you may define all of the dependencies for the Customers module.
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
    | Here you may define all of the permissions for the Customers module.
    |
    */

    'permissions' => [
        'view' => 'View Customers',
        'create' => 'Create Customers',
        'edit' => 'Edit Customers',
        'delete' => 'Delete Customers',
    ],
]; 