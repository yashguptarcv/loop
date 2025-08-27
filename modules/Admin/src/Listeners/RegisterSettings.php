<?php

namespace Modules\Admin\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register(
            [
                'title' => 'General Settings',
                'description' => 'Configure store name, contact information, and basic preferences.',
                'route' => route('admin.settings.general.index'),
                'icon' => 'settings',
                'permission' => 'admin.settings.general.index'
            ]
        );

        $event->register(
            [
                'title' => 'Currencies',
                'description' => 'Configure accepted currencies and exchange rates.',
                'route' => route('admin.settings.currencies.index'),
                'icon' => 'currency_exchange',
                'permission' => 'admin.settings.currencies.index'
            ]
        );

        $event->register(
            [
                'title' => 'Countries',
                'description' => 'Manage countries where you operate and ship to.',
                'route' => route('admin.settings.countries.index'),
                'icon' => 'public',
                'permission' => 'admin.settings.countries.index'
            ]
        );

        $event->register(
            [
                'title' => 'States',
                'description' => 'Manage states/regions for tax and shipping calculations.',
                'route' => route('admin.settings.states.index'),
                'icon' => 'map',
                'permission' => 'admin.settings.states.index'
            ]
        );

        $event->register(
            [
                'title' => 'Roles & Permissions',
                'description' => 'Assign roles and permissions to users.',
                'route' => route('admin.settings.roles.index'),
                'icon' => 'admin_panel_settings',
                'permission' => 'admin.settings.roles.index'
            ]
        );

        $event->register(
            [
                'title' => 'Users',
                'description' => 'Manage onboarding and settings for new users.',
                'route' => route('admin.settings.users.index'),
                'icon' => 'people',
                'permission' => 'admin.settings.users.index'
            ]
        );
    }
}
