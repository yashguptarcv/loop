<?php

namespace Modules\Widgets\Providers;

use Modules\Widgets\Events\RenderWidgets;
use Modules\Widgets\Listeners\InjectWidgets;
use Modules\Core\Events\RegisterSettingsMenu;
use Modules\Widgets\Listeners\RegisterSettings;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class WidgetsEventServiceProvider extends ServiceProvider
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

        RenderWidgets::class => [
            InjectWidgets::class,
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
