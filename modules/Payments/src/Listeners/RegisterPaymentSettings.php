<?php

namespace Modules\Payments\Listeners;

use Modules\Core\Events\RegisterSettingsMenu;

class RegisterPaymentSettings
{
    public function handle(RegisterSettingsMenu $event): void
    {
        $event->register([
            'title' => 'Payment Methods',
            'description' => 'Set up payment gateways like PayPal, Stripe, and others.',
            'route' => route('admin.payments.index'),
            'icon' => 'payments',
            'permission' => 'admin.payments.index'
        ]);
    }
}
