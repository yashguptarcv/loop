<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Meetings Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Meetings module.
    |
    */

    'name' => 'Meetings',
    'version' => '1.0.0',
    'description' => 'Meetings module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Meetings module.
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
    | Here you may define all of the dependencies for the Meetings module.
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
    | Here you may define all of the permissions for the Meetings module.
    |
    */

    'meeting_colors' => [
        'blue'   => 'primary',
        'red'    => 'danger',
        'blue'   => 'secondary',
        'blue'   => 'primary',
    ],

    'permissions' => [
        'view' => 'View Meetings',
        'create' => 'Create Meetings',
        'edit' => 'Edit Meetings',
        'delete' => 'Delete Meetings',
    ],
]; 