<?php

namespace Modules\Widgets\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register(
            [
                'title' => 'Widgets',
                'description' => 'Manage widgets ( stat, pie, chart, world map, list )',
                'route' => route('admin.widgets.index'),
                'icon' => 'settings',
                'permission' => 'admin.widgets.index'
            ]
        );
    }
}
