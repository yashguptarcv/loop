<?php

namespace Modules\Notifications\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterNotificationSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register(
            [
                'title' => 'Notifications',
                'description' => 'View system notification logs.',
                'route' => route('admin.notification.index'),
                'icon' => 'edit_notifications',
                'permission' => 'admin.notification.index'
            ]
        );

        $event->register(
            [
                'title' => 'Logs',
                'description' => 'View system activity logs and error reports.',
                'route' => route('admin.logs.index'),
                'icon' => 'list_alt',
                'permission' => 'admin.logs.index'
            ]
        );
    }
}
