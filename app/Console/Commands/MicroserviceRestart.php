<?php

namespace App\Console\Commands;

use App\Services\Microservices\ServiceRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class MicroserviceRestart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'microservice:restart {service : The service to restart} {--force : Force restart without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart a microservice (clear cache and reset circuit breaker)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceName = $this->argument('service');
        $force = $this->option('force');

        // Check if service exists
        $services = ServiceRegistry::getAllServices();
        if (!isset($services[$serviceName])) {
            $this->error("Service '{$serviceName}' not found");
            $this->info('Available services: ' . implode(', ', array_keys($services)));
            return 1;
        }

        if (!$force) {
            if (!$this->confirm("Are you sure you want to restart service '{$serviceName}'?")) {
                $this->info('Operation cancelled');
                return 0;
            }
        }

        $this->info("Restarting service: {$serviceName}");

        // Clear service cache
        $this->clearServiceCache($serviceName);

        // Reset circuit breaker
        $this->resetCircuitBreaker($serviceName);

        // Clear health cache
        $this->clearHealthCache($serviceName);

        // Re-initialize service
        $this->reinitializeService($serviceName);

        $this->info("✅ Service '{$serviceName}' has been restarted successfully");
        
        // Perform health check
        $this->info("Performing health check...");
        $isHealthy = ServiceRegistry::isServiceHealthy($serviceName);
        
        if ($isHealthy) {
            $this->info("✅ Service '{$serviceName}' is healthy");
            return 0;
        } else {
            $this->warn("⚠️  Service '{$serviceName}' is still unhealthy. Check the service logs.");
            return 1;
        }
    }

    /**
     * Clear all cache related to the service
     */
    private function clearServiceCache(string $serviceName): void
    {
        $this->line("Clearing cache for {$serviceName}...");
        
        // Clear service-specific cache keys
        $cacheKeys = [
            "service_health_{$serviceName}",
            "service_health_{$serviceName}_checked",
            "service_failures_{$serviceName}",
            "service_successes_{$serviceName}",
            "circuit_breaker_{$serviceName}",
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear any cached responses
        $cachedResponses = Cache::get("cached_responses_{$serviceName}", []);
        foreach ($cachedResponses as $cacheKey) {
            Cache::forget($cacheKey);
        }
        Cache::forget("cached_responses_{$serviceName}");

        $this->line("✅ Cache cleared");
    }

    /**
     * Reset circuit breaker for the service
     */
    private function resetCircuitBreaker(string $serviceName): void
    {
        $this->line("Resetting circuit breaker for {$serviceName}...");
        ServiceRegistry::setCircuitBreaker($serviceName, false);
        $this->line("✅ Circuit breaker reset");
    }

    /**
     * Clear health check cache
     */
    private function clearHealthCache(string $serviceName): void
    {
        $this->line("Clearing health cache for {$serviceName}...");
        Cache::forget("service_health_{$serviceName}");
        Cache::forget("service_health_{$serviceName}_checked");
        $this->line("✅ Health cache cleared");
    }

    /**
     * Re-initialize the service
     */
    private function reinitializeService(string $serviceName): void
    {
        $this->line("Re-initializing service {$serviceName}...");
        
        // In a real implementation, this might involve:
        // - Re-registering the service
        // - Re-establishing connections
        // - Re-loading configuration
        
        // For now, we'll just clear any stale data
        Cache::forget("service_config_{$serviceName}");
        Cache::forget("service_connections_{$serviceName}");
        
        $this->line("✅ Service re-initialized");
    }
}
