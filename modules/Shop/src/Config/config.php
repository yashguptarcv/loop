<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shop Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Shop module.
    |
    */

    'name' => 'Shop',
    'version' => '1.0.0',
    'description' => 'Shop module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Shop module.
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
    | Here you may define all of the dependencies for the Shop module.
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
    | Here you may define all of the permissions for the Shop module.
    |
    */

    'permissions' => [
        'view' => 'View Shop',
        'create' => 'Create Shop',
        'edit' => 'Edit Shop',
        'delete' => 'Delete Shop',
    ],
]; 