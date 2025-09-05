<?php

namespace Modules\Payments\Providers;

use Modules\Core\Events\RegisterSettingsMenu;
use Modules\Payments\Listeners\RegisterPaymentSettings;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class PaymentsEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegisterSettingsMenu::class => [
            RegisterPaymentSettings::class,
            // add more listeners from other modules
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
} 