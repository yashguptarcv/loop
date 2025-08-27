<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DataExport Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the DataExport module.
    |
    */

    'name' => 'DataExport',
    'version' => '1.0.0',
    'description' => 'DataExport module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the DataExport module.
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
    | Here you may define all of the dependencies for the DataExport module.
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
    | Here you may define all of the permissions for the DataExport module.
    |
    */

    'permissions' => [
        'view' => 'View DataExport',
        'create' => 'Create DataExport',
        'edit' => 'Edit DataExport',
        'delete' => 'Delete DataExport',
    ],
]; 