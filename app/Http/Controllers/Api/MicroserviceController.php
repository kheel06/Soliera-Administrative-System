<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Microservices\ServiceRegistry;
use App\Services\Microservices\ServiceGateway;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class MicroserviceController extends Controller
{
    private ServiceGateway $gateway;

    public function __construct(ServiceGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Get health status of all microservices
     */
    public function health(): JsonResponse
    {
        try {
            $services = ServiceRegistry::getAllServices();
            $healthStatus = $this->gateway->getHealthStatus();
            $metrics = ServiceRegistry::getServiceMetrics();

            $statusData = [];
            foreach ($services as $name => $config) {
                $statusData[$name] = [
                    'url' => $config['url'],
                    'healthy' => $healthStatus[$name]['healthy'] ?? false,
                    'circuit_breaker_open' => $healthStatus[$name]['circuit_breaker_open'] ?? false,
                    'recent_failures' => $healthStatus[$name]['recent_failures'] ?? 0,
                    'recent_successes' => $healthStatus[$name]['recent_successes'] ?? 0,
                    'last_check' => $metrics[$name]['last_check'] ?? null,
                ];
            }

            return response()->json([
                'success' => true,
                'services' => $statusData,
                'summary' => [
                    'total' => count($services),
                    'healthy' => count(array_filter($healthStatus, fn($s) => $s['healthy'])),
                    'unhealthy' => count(array_filter($healthStatus, fn($s) => !$s['healthy'])),
                    'circuit_breakers_open' => count(array_filter($healthStatus, fn($s) => $s['circuit_breaker_open'])),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get microservice health status', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get health status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed metrics for a specific service
     */
    public function serviceMetrics(string $serviceName): JsonResponse
    {
        try {
            $service = ServiceRegistry::getService($serviceName);
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => "Service '{$serviceName}' not found"
                ], 404);
            }

            $healthStatus = $this->gateway->getHealthStatus();
            $serviceStatus = $healthStatus[$serviceName] ?? [];

            return response()->json([
                'success' => true,
                'service' => $serviceName,
                'config' => $service,
                'status' => $serviceStatus,
                'metrics' => [
                    'uptime_percentage' => $this->calculateUptimePercentage($serviceName),
                    'average_response_time' => $this->getAverageResponseTime($serviceName),
                    'total_requests' => $this->getTotalRequests($serviceName),
                    'error_rate' => $this->getErrorRate($serviceName),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to get metrics for service {$serviceName}", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get service metrics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test service connectivity
     */
    public function testService(string $serviceName): JsonResponse
    {
        try {
            $serviceInstance = $this->gateway->getService($serviceName);
            if (!$serviceInstance) {
                return response()->json([
                    'success' => false,
                    'message' => "Service '{$serviceName}' is not available"
                ], 503);
            }

            $startTime = microtime(true);
            $isHealthy = ServiceRegistry::isServiceHealthy($serviceName);
            $responseTime = (microtime(true) - $startTime) * 1000;

            return response()->json([
                'success' => true,
                'service' => $serviceName,
                'healthy' => $isHealthy,
                'response_time_ms' => round($responseTime, 2),
                'timestamp' => now()->toISOString(),
                'status' => $isHealthy ? 'operational' : 'failed'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to test service {$serviceName}", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Service test failed: ' . $e->getMessage(),
                'response_time_ms' => null,
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Reset circuit breaker for a service
     */
    public function resetCircuitBreaker(string $serviceName): JsonResponse
    {
        try {
            ServiceRegistry::setCircuitBreaker($serviceName, false);
            
            Log::info("Circuit breaker reset for service {$serviceName}");
            
            return response()->json([
                'success' => true,
                'message' => "Circuit breaker reset for service '{$serviceName}'",
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to reset circuit breaker for {$serviceName}", ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset circuit breaker: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute service operation with fallback
     */
    public function executeOperation(Request $request): JsonResponse
    {
        try {
            $serviceName = $request->input('service');
            $operation = $request->input('operation');
            $parameters = $request->input('parameters', []);

            if (!$serviceName || !$operation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service name and operation are required'
                ], 400);
            }

            $result = $this->gateway->executeWithFallback(
                $serviceName,
                function ($service) use ($operation, $parameters) {
                    return $this->executeServiceOperation($service, $operation, $parameters);
                },
                function () use ($serviceName, $operation) {
                    return [
                        'success' => false,
                        'message' => 'Operation executed using fallback service',
                        'service' => $serviceName,
                        'operation' => $operation,
                        'fallback_used' => true
                    ];
                }
            );

            return response()->json([
                'success' => true,
                'result' => $result,
                'service' => $serviceName,
                'operation' => $operation,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to execute service operation', [
                'service' => $request->input('service'),
                'operation' => $request->input('operation'),
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Operation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get service registry information
     */
    public function registry(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'registered_services' => ServiceRegistry::getAllServices(),
                'healthy_services' => ServiceRegistry::getHealthyServices(),
                'metrics' => ServiceRegistry::getServiceMetrics(),
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to get service registry info', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get registry info: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Execute a specific operation on a service
     */
    private function executeServiceOperation($service, string $operation, array $parameters): array
    {
        // This would be expanded based on actual service operations
        switch ($operation) {
            case 'health_check':
                return ['healthy' => $service->healthCheck()];
            
            case 'ping':
                return ['pong' => true, 'timestamp' => now()->toISOString()];
            
            default:
                throw new \Exception("Unknown operation: {$operation}");
        }
    }

    /**
     * Calculate uptime percentage for a service
     */
    private function calculateUptimePercentage(string $serviceName): float
    {
        // This would typically be calculated from historical data
        // For now, return a mock value
        return 99.5;
    }

    /**
     * Get average response time for a service
     */
    private function getAverageResponseTime(string $serviceName): float
    {
        // This would typically be calculated from metrics
        return 150.5; // milliseconds
    }

    /**
     * Get total requests for a service
     */
    private function getTotalRequests(string $serviceName): int
    {
        // This would typically be calculated from metrics
        return 1250;
    }

    /**
     * Get error rate for a service
     */
    private function getErrorRate(string $serviceName): float
    {
        // This would typically be calculated from metrics
        return 0.5; // percentage
    }
}
