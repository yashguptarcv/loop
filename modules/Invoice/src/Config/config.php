<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Invoice Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Invoice module.
    |
    */

    'name' => 'Invoice',
    'version' => '1.0.0',
    'description' => 'Invoice module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Invoice module.
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
    | Here you may define all of the dependencies for the Invoice module.
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
    | Here you may define all of the permissions for the Invoice module.
    |
    */

    'permissions' => [
        'view' => 'View Invoice',
        'create' => 'Create Invoice',
        'edit' => 'Edit Invoice',
        'delete' => 'Delete Invoice',
    ],
]; 