<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Square Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Square module.
    |
    */

    'name' => 'Square',
    'version' => '1.0.0',
    'description' => 'Square module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Square module.
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
    | Here you may define all of the dependencies for the Square module.
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
    | Here you may define all of the permissions for the Square module.
    |
    */

    'permissions' => [
        'view' => 'View Square',
        'create' => 'Create Square',
        'edit' => 'Edit Square',
        'delete' => 'Delete Square',
    ],
]; 