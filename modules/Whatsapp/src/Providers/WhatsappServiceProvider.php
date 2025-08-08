<?php

namespace Modules\Whatsapp\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class WhatsappServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Whatsapp';
    protected $moduleNameLower = 'whatsapp';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'whatsapp'
        );

        $this->app->register(WhatsappEventServiceProvider::class);
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
            __DIR__.'/../Config/config.php' => config_path('whatsapp.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'whatsapp'
        );
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // Add your commands here
            ]);
        }
    } 

    /**
     * Register routes.
     */
    protected function registerRoutes(): void
    {
        try {
            $webRoutePath = __DIR__.'/../Routes/web.php';
            $apiRoutePath = __DIR__.'/../Routes/api.php';

            if (file_exists($webRoutePath)) {
                $this->loadRoutesFrom($webRoutePath);
            }

            if (file_exists($apiRoutePath)) {
                $this->loadRoutesFrom($apiRoutePath);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error in CustomersServiceProvider registerRoutes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/whatsapp');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'whatsapp-module-views']);

        $this->loadViewsFrom($sourcePath, 'whatsapp');
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'whatsapp');
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
    * Register compoenents
    */

    protected function registerComponents(): void
    {
       
    }
} 