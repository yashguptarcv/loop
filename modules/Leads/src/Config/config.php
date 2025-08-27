<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Leads Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Leads module.
    |
    */

    'name' => 'Leads',
    'version' => '1.0.0',
    'description' => 'Leads module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Leads module.
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
    | Here you may define all of the dependencies for the Leads module.
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
    | Here you may define all of the permissions for the Leads module.
    |
    */

    'lead_options' => [
        'general'   => 'General',
        'call'      => 'Call',
        'email'     => 'Email',
        'meeting'   => 'Meeting',
        'whatsapp'  => 'Whatsapp',
        'schedule_meeting'  => 'Schedule Meeting'
    ],

    'out_comes' => [
        'positive'  => 'Positive',
        'neutral'   => 'Neutral',
        'negative'  => 'Negative',
        'follow_up' => 'Follow Up Needed'
    ],

    'permissions' => [
        'view' => 'View Leads',
        'create' => 'Create Leads',
        'edit' => 'Edit Leads',
        'delete' => 'Delete Leads',
    ],
]; 