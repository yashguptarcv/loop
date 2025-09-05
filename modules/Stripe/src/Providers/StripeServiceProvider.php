<?php

namespace Modules\Stripe\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Square\Processors\SquareProcessor;
use Modules\Stripe\Processors\StripeProcessor;
use Modules\Payments\Services\PaymentsProcessorRegistry;

class StripeServiceProvider extends ServiceProvider
{
    protected $moduleName = 'Stripe';
    protected $moduleNameLower = 'stripe';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'stripe'
        );

        $this->app->register(StripeEventServiceProvider::class);

        // Register the PaymentsProcessorRegistry singleton
        $this->app->singleton(PaymentsProcessorRegistry::class, function ($app) {
            $registry = new PaymentsProcessorRegistry();
            $this->registerProcessors($registry);
            
            return $registry;
        });
    }

    /**
     * Register the available payment processors.
     */
    protected function registerProcessors(PaymentsProcessorRegistry $registry): void
    {
        // Register Stripe processor
        $stripeProcessor = new StripeProcessor();
        $registry->register('stripe', $stripeProcessor);
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
            __DIR__.'/../Config/config.php' => config_path('stripe.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'stripe'
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
            \Illuminate\Support\Facades\Log::error("Error in StripeServiceProvider registerRoutes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Register views.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/stripe');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'stripe-module-views']);

        $this->loadViewsFrom($sourcePath, 'stripe');
    }

    /**
     * Register translations.
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'stripe');
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