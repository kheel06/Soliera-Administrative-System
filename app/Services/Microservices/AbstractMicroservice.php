<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

abstract class AbstractMicroservice
{
    protected string $baseUrl;
    protected string $serviceName;
    protected array $headers = [];
    protected int $timeout = 30;
    protected int $retryAttempts = 3;

    public function __construct()
    {
        $this->baseUrl = config('microservices.' . $this->serviceName . '.url');
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Service-Name' => $this->serviceName,
            'X-Request-ID' => uniqid('req_', true)
        ];

        if ($apiKey = config('microservices.' . $this->serviceName . '.api_key')) {
            $this->headers['Authorization'] = 'Bearer ' . $apiKey;
        }
    }

    /**
     * Make HTTP request to microservice
     */
    protected function request(string $method, string $endpoint, array $data = [], array $headers = [])
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        $requestHeaders = array_merge($this->headers, $headers);

        $attempt = 0;
        while ($attempt < $this->retryAttempts) {
            try {
                $response = Http::timeout($this->timeout)
                    ->withHeaders($requestHeaders)
                    ->{$method}($url, $data);

                if ($response->successful()) {
                    return $response->json();
                }

                throw new Exception("HTTP {$response->status()}: {$response->body()}");
            } catch (Exception $e) {
                $attempt++;
                if ($attempt >= $this->retryAttempts) {
                    Log::error("Microservice request failed after {$attempt} attempts", [
                        'service' => $this->serviceName,
                        'url' => $url,
                        'method' => $method,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
                
                // Exponential backoff
                usleep(pow(2, $attempt) * 100000);
            }
        }
    }

    /**
     * GET request
     */
    protected function get(string $endpoint, array $params = [], array $headers = [])
    {
        $query = !empty($params) ? '?' . http_build_query($params) : '';
        return $this->request('get', $endpoint . $query, [], $headers);
    }

    /**
     * POST request
     */
    protected function post(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('post', $endpoint, $data, $headers);
    }

    /**
     * PUT request
     */
    protected function put(string $endpoint, array $data = [], array $headers = [])
    {
        return $this->request('put', $endpoint, $data, $headers);
    }

    /**
     * DELETE request
     */
    protected function delete(string $endpoint, array $headers = [])
    {
        return $this->request('delete', $endpoint, [], $headers);
    }

    /**
     * Health check for microservice
     */
    public function healthCheck(): bool
    {
        try {
            $response = $this->get('/health');
            return isset($response['status']) && $response['status'] === 'healthy';
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Circuit breaker pattern
     */
    protected function executeWithCircuitBreaker(callable $operation, string $cacheKey = null, int $cacheTtl = 300)
    {
        if ($cacheKey && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $result = $operation();
            
            if ($cacheKey) {
                Cache::put($cacheKey, $result, $cacheTtl);
            }
            
            return $result;
        } catch (Exception $e) {
            // Fallback to cache if available
            if ($cacheKey && Cache::has($cacheKey . '_fallback')) {
                Log::warning("Using fallback cache for {$cacheKey}", ['error' => $e->getMessage()]);
                return Cache::get($cacheKey . '_fallback');
            }
            
            throw $e;
        }
    }

    /**
     * Log service communication
     */
    protected function logCommunication(string $action, array $data = [], array $response = [])
    {
        Log::info("Microservice communication", [
            'service' => $this->serviceName,
            'action' => $action,
            'request_data' => $data,
            'response_data' => $response,
            'timestamp' => now()->toISOString()
        ]);
    }
}
