<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Whatsapp Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Whatsapp module.
    |
    */

    'name' => 'Whatsapp',
    'version' => '1.0.0',
    'description' => 'Whatsapp module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Whatsapp module.
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
    | Here you may define all of the dependencies for the Whatsapp module.
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
    | Here you may define all of the permissions for the Whatsapp module.
    |
    */

    'permissions' => [
        'view' => 'View Whatsapp',
        'create' => 'Create Whatsapp',
        'edit' => 'Edit Whatsapp',
        'delete' => 'Delete Whatsapp',
    ],
]; 