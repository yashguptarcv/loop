<?php

namespace Modules\DataExport\Providers;

use Modules\Core\Events\RegisterSettingsMenu;
use Modules\DataExport\Listeners\RegisterSettings;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class DataExportEventServiceProvider extends ServiceProvider
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