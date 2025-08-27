<?php

namespace Modules\Leads\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register([
          'title' => 'Lead Configuration',
            'description' => 'Manage Lead Tracking / Tags / Sources',
            'route' => route('admin.statuses.leads.index'),
            'icon' => 'flag',
            'permission' => 'admin.statuses.leads.index'
        ]);
    }
}
