<?php

namespace Modules\Admin\Providers;

use Modules\Admin\Listeners\RegisterSettings;
use Modules\Core\Events\RegisterSettingsMenu;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class AdminEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegisterSettingsMenu::class => [
            RegisterSettings::class,
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