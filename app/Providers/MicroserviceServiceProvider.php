<?php

namespace App\Providers;

use App\Services\Microservices\ServiceRegistry;
use App\Services\Microservices\ServiceGateway;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class MicroserviceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the service gateway as a singleton
        $this->app->singleton(ServiceGateway::class, function ($app) {
            return ServiceGateway::getInstance();
        });

        // Register service registry
        $this->app->singleton(ServiceRegistry::class, function ($app) {
            return new ServiceRegistry();
        });

        // Register individual services
        $this->registerMicroservices();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Initialize service registry
        ServiceRegistry::initialize();

        // Warm up service connections
        if (app()->environment('production')) {
            $gateway = ServiceGateway::getInstance();
            $gateway->warmUp();
        }

        // Register console commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\MicroserviceHealthCheck::class,
                \App\Console\Commands\MicroserviceStatus::class,
                \App\Console\Commands\MicroserviceRestart::class,
            ]);

            // Schedule health checks
            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('microservice:health-check')->everyMinute();
                $schedule->command('microservice:status')->hourly();
            });
        }

        // Register routes for microservice monitoring
        $this->loadRoutesFrom(base_path('routes/microservices.php'));
    }

    /**
     * Register individual microservice classes
     */
    private function registerMicroservices(): void
    {
        $this->app->singleton(\App\Services\Microservices\DocumentService::class);
        $this->app->singleton(\App\Services\Microservices\VisitorService::class);
        $this->app->singleton(\App\Services\Microservices\FacilityService::class);
        $this->app->singleton(\App\Services\Microservices\LegalService::class);
        $this->app->singleton(\App\Services\Microservices\NotificationService::class);
        $this->app->singleton(\App\Services\Microservices\AuthService::class);
        $this->app->singleton(\App\Services\Microservices\AIService::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            ServiceGateway::class,
            ServiceRegistry::class,
            \App\Services\Microservices\DocumentService::class,
            \App\Services\Microservices\VisitorService::class,
            \App\Services\Microservices\FacilityService::class,
            \App\Services\Microservices\LegalService::class,
            \App\Services\Microservices\NotificationService::class,
            \App\Services\Microservices\AuthService::class,
            \App\Services\Microservices\AIService::class,
        ];
    }
}
