<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ServiceRegistry
{
    private static array $services = [];
    private static array $serviceHealth = [];

    /**
     * Register a microservice
     */
    public static function register(string $name, string $url, array $options = []): void
    {
        self::$services[$name] = array_merge([
            'url' => $url,
            'timeout' => 30,
            'retry_attempts' => 3,
            'api_key' => null,
            'health_check_interval' => 60, // seconds
            'circuit_breaker_threshold' => 5,
            'circuit_breaker_timeout' => 300 // seconds
        ], $options);

        Log::info("Microservice registered", ['service' => $name, 'url' => $url]);
    }

    /**
     * Get service configuration
     */
    public static function getService(string $name): ?array
    {
        return self::$services[$name] ?? null;
    }

    /**
     * Get all registered services
     */
    public static function getAllServices(): array
    {
        return self::$services;
    }

    /**
     * Check if service is healthy
     */
    public static function isServiceHealthy(string $name): bool
    {
        $cacheKey = "service_health_{$name}";
        
        // Check cache first
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey) === 'healthy';
        }

        // Perform health check
        $service = self::getService($name);
        if (!$service) {
            return false;
        }

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 10]);
            $response = $client->get($service['url'] . '/health');
            
            $isHealthy = $response->getStatusCode() === 200;
            Cache::put($cacheKey, $isHealthy ? 'healthy' : 'unhealthy', 60);
            
            self::$serviceHealth[$name] = $isHealthy;
            return $isHealthy;
        } catch (\Exception $e) {
            Log::warning("Service health check failed", ['service' => $name, 'error' => $e->getMessage()]);
            Cache::put($cacheKey, 'unhealthy', 60);
            self::$serviceHealth[$name] = false;
            return false;
        }
    }

    /**
     * Get all healthy services
     */
    public static function getHealthyServices(): array
    {
        $healthy = [];
        foreach (array_keys(self::$services) as $name) {
            if (self::isServiceHealthy($name)) {
                $healthy[$name] = self::$services[$name];
            }
        }
        return $healthy;
    }

    /**
     * Get service URL
     */
    public static function getServiceUrl(string $name): ?string
    {
        $service = self::getService($name);
        return $service['url'] ?? null;
    }

    /**
     * Load services from configuration
     */
    public static function loadFromConfig(): void
    {
        $config = config('microservices', []);
        
        foreach ($config as $name => $serviceConfig) {
            if (is_array($serviceConfig) && isset($serviceConfig['url'])) {
                self::register($name, $serviceConfig['url'], $serviceConfig);
            }
        }
    }

    /**
     * Initialize service registry
     */
    public static function initialize(): void
    {
        // Load from config file
        self::loadFromConfig();
        
        // Register default services if not in config
        if (empty(self::$services)) {
            self::registerDefaultServices();
        }
        
        Log::info("Service registry initialized", ['services' => array_keys(self::$services)]);
    }

    /**
     * Register default services
     */
    private static function registerDefaultServices(): void
    {
        self::register('document', env('DOCUMENT_SERVICE_URL', 'http://localhost:8001'));
        self::register('visitor', env('VISITOR_SERVICE_URL', 'http://localhost:8002'));
        self::register('facility', env('FACILITY_SERVICE_URL', 'http://localhost:8003'));
        self::register('legal', env('LEGAL_SERVICE_URL', 'http://localhost:8004'));
        self::register('notification', env('NOTIFICATION_SERVICE_URL', 'http://localhost:8005'));
        self::register('auth', env('AUTH_SERVICE_URL', 'http://localhost:8006'));
        self::register('ai', env('AI_SERVICE_URL', 'http://localhost:8007'));
    }

    /**
     * Get service instance
     */
    public static function getServiceInstance(string $name): ?AbstractMicroservice
    {
        if (!self::isServiceHealthy($name)) {
            Log::warning("Attempting to use unhealthy service", ['service' => $name]);
            return null;
        }

        $serviceClass = match($name) {
            'document' => DocumentService::class,
            'visitor' => VisitorService::class,
            'facility' => FacilityService::class,
            'legal' => LegalService::class,
            'notification' => NotificationService::class,
            default => null
        };

        if ($serviceClass && class_exists($serviceClass)) {
            return new $serviceClass();
        }

        return null;
    }

    /**
     * Deregister service
     */
    public static function deregister(string $name): void
    {
        unset(self::$services[$name]);
        unset(self::$serviceHealth[$name]);
        Cache::forget("service_health_{$name}");
        
        Log::info("Microservice deregistered", ['service' => $name]);
    }

    /**
     * Update service configuration
     */
    public static function updateService(string $name, array $options): void
    {
        if (isset(self::$services[$name])) {
            self::$services[$name] = array_merge(self::$services[$name], $options);
            Log::info("Microservice updated", ['service' => $name, 'options' => $options]);
        }
    }

    /**
     * Get service metrics
     */
    public static function getServiceMetrics(): array
    {
        $metrics = [];
        foreach (self::$services as $name => $service) {
            $metrics[$name] = [
                'url' => $service['url'],
                'healthy' => self::isServiceHealthy($name),
                'last_check' => Cache::get("service_health_{$name}_checked", null),
                'circuit_breaker_open' => Cache::get("circuit_breaker_{$name}", false)
            ];
        }
        return $metrics;
    }

    /**
     * Enable/disable circuit breaker for service
     */
    public static function setCircuitBreaker(string $name, bool $open): void
    {
        $cacheKey = "circuit_breaker_{$name}";
        if ($open) {
            Cache::put($cacheKey, true, 300); // 5 minutes
        } else {
            Cache::forget($cacheKey);
        }
    }

    /**
     * Check if circuit breaker is open for service
     */
    public static function isCircuitBreakerOpen(string $name): bool
    {
        return Cache::get("circuit_breaker_{$name}", false);
    }
}
