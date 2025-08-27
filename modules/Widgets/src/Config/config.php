<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Widgets Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Widgets module.
    |
    */

    'name' => 'Widgets',
    'version' => '1.0.0',
    'description' => 'Widgets module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Widgets module.
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
    | Here you may define all of the dependencies for the Widgets module.
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
    | Here you may define all of the permissions for the Widgets module.
    |
    */

    'permissions' => [
        'view' => 'View Widgets',
        'create' => 'Create Widgets',
        'edit' => 'Edit Widgets',
        'delete' => 'Delete Widgets',
    ],
]; 