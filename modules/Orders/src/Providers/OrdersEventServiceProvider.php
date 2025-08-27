<?php

namespace Modules\Orders\Providers;

use Modules\Core\Events\RegisterSettingsMenu;
use Modules\Orders\Listeners\RegisterOrdersSettings;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class OrdersEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegisterSettingsMenu::class => [
            RegisterOrdersSettings::class,
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