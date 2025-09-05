<?php

namespace Modules\DataExport\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register(
            [
                'title' => 'Import Data',
                'description' => 'Import Data using CSV, XLS, XML via file',
                'route' => '#',
                'icon' => 'upload',
                'permission' => ''
            ]
        );
    }
}
