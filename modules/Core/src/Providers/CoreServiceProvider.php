<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class CoreServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Core';
    protected $moduleNameLower = 'core';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'core'
        );
       
         $configPath = __DIR__ . '/../Config';

        foreach (glob($configPath . '/*.php') as $file) {
            $filename = basename($file, '.php');

            if ($filename === 'config') {
                // Merge main config file as 'subscription'
                $this->mergeConfigFrom($file, 'core');
            } else {
                // Merge others as 'subscription.filename'
                $this->mergeConfigFrom($file, "core::$filename");
            }
        }


        $this->app->register(CoreEventServiceProvider::class);
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
            __DIR__.'/../Config/config.php' => config_path('core.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'core'
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
            \Illuminate\Support\Facades\Log::error("Error in CoreServiceProvider registerRoutes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/core');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'core-module-views']);

        $this->loadViewsFrom($sourcePath, 'core');
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'core');
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