<?php

namespace Modules\Orders\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterOrdersSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register([
           'title' => 'Order Status',
            'description' => 'Manage order status',
            'route' => route('admin.orders-statuses.index'),
            'icon' => 'flag',
            'permission' => 'admin.orders-statuses.index'
        ]);
    }
}
