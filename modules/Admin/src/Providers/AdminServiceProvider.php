<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

use Modules\Admin\View\Components\Common\Button;
use Modules\Admin\View\Components\Common\DeleteModal;
use Modules\Admin\View\Components\Common\StatusModal;
use Modules\Admin\View\Components\DataView\Layout;
use Modules\Admin\View\Components\DataView\Partials\Pagination;
use Modules\Admin\View\Components\DataView\Partials\Sidebar;
use Modules\Admin\View\Components\DataView\Partials\Table;
use Modules\Admin\View\Components\DataView\Partials\TopControls;
use Modules\Admin\View\Components\Sidebar\Link;


class AdminServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Admin';
    protected $moduleNameLower = 'admin';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'admin'
        );
        $configPath = __DIR__ . '/../Config';

        foreach (glob($configPath . '/*.php') as $file) {
            $filename = basename($file, '.php');

            if ($filename === 'config') {
                // Merge main config file as 'subscription'
                $this->mergeConfigFrom($file, 'admin');
            } else {
                // Merge others as 'subscription.filename'
                $this->mergeConfigFrom($file, "admin::$filename");
            }
        }






        $this->app->register(AdminEventServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerCommands();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerMigrations();
        $this->registerComponents();
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('admin.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'admin'
        );
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([

            ]);
        }
    }

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        try {
            $webRoutePath = __DIR__ . '/../Routes/web.php';
            $apiRoutePath = __DIR__ . '/../Routes/api.php';

            if (file_exists($webRoutePath)) {
                $this->loadRoutesFrom($webRoutePath);
            }

            if (file_exists($apiRoutePath)) {
                $this->loadRoutesFrom($apiRoutePath);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in AdminServiceProvider registerRoutes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/admin');
        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'admin-module-views']);

        $this->loadViewsFrom($sourcePath, 'admin');
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'admin');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register compoenents
     */

    protected function registerComponents(): void
    {
        Blade::component('sidebar.link', Link::class);
        Blade::component('button', Button::class);
        Blade::component('delete-modal', DeleteModal::class);
        Blade::component('status-modal', StatusModal::class);
        
    }
}