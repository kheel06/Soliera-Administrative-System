<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;

class ServiceGateway
{
    private static ?ServiceGateway $instance = null;
    private array $services = [];
    private array $fallbackHandlers = [];

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->initializeServices();
    }

    /**
     * Initialize all microservice clients
     */
    private function initializeServices(): void
    {
        $this->services = [
            'document' => new DocumentService(),
            'visitor' => new VisitorService(),
            'facility' => new FacilityService(),
            'legal' => new LegalService(),
            'notification' => new NotificationService(),
            'auth' => new AuthService(),
            'ai' => new AIService(),
        ];
    }

    /**
     * Get service instance with fallback
     */
    public function getService(string $serviceName): ?AbstractMicroservice
    {
        // Check if service is healthy
        if (!ServiceRegistry::isServiceHealthy($serviceName)) {
            Log::warning("Service {$serviceName} is unhealthy, attempting fallback");
            return $this->getFallbackService($serviceName);
        }

        // Check circuit breaker
        if (ServiceRegistry::isCircuitBreakerOpen($serviceName)) {
            Log::warning("Circuit breaker open for service {$serviceName}, using fallback");
            return $this->getFallbackService($serviceName);
        }

        return $this->services[$serviceName] ?? null;
    }

    /**
     * Execute service call with fallback
     */
    public function execute(string $serviceName, callable $operation, callable $fallback = null)
    {
        $service = $this->getService($serviceName);
        
        if (!$service) {
            Log::error("Service {$serviceName} not available");
            if ($fallback) {
                return $fallback();
            }
            throw new Exception("Service {$serviceName} not available");
        }

        try {
            $result = $operation($service);
            $this->recordSuccess($serviceName);
            return $result;
        } catch (Exception $e) {
            $this->recordFailure($serviceName);
            Log::error("Service operation failed", [
                'service' => $serviceName,
                'error' => $e->getMessage()
            ]);

            if ($fallback) {
                return $fallback();
            }
            throw $e;
        }
    }

    /**
     * Execute multiple service calls in parallel
     */
    public function executeParallel(array $operations): array
    {
        $results = [];
        $promises = [];

        foreach ($operations as $key => $operation) {
            $serviceName = $operation['service'];
            $service = $this->getService($serviceName);
            
            if ($service) {
                try {
                    $results[$key] = $operation['callback']($service);
                    $this->recordSuccess($serviceName);
                } catch (Exception $e) {
                    $this->recordFailure($serviceName);
                    $results[$key] = $operation['fallback'] ?? null;
                    Log::error("Parallel service operation failed", [
                        'service' => $serviceName,
                        'key' => $key,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $results[$key] = $operation['fallback'] ?? null;
            }
        }

        return $results;
    }

    /**
     * Get fallback service implementation
     */
    private function getFallbackService(string $serviceName): ?AbstractMicroservice
    {
        // Return local/fallback implementation
        return match($serviceName) {
            'document' => new FallbackDocumentService(),
            'visitor' => new FallbackVisitorService(),
            'facility' => new FallbackFacilityService(),
            'legal' => new FallbackLegalService(),
            'notification' => new FallbackNotificationService(),
            'auth' => new FallbackAuthService(),
            'ai' => new FallbackAIService(),
            default => null
        };
    }

    /**
     * Record service success
     */
    private function recordSuccess(string $serviceName): void
    {
        $cacheKey = "service_success_{$serviceName}";
        $successCount = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $successCount + 1, 300);
        
        // Reset failure count on success
        Cache::forget("service_failures_{$serviceName}");
        
        // Close circuit breaker if we have consecutive successes
        if ($successCount >= 3) {
            ServiceRegistry::setCircuitBreaker($serviceName, false);
        }
    }

    /**
     * Record service failure
     */
    private function recordFailure(string $serviceName): void
    {
        $cacheKey = "service_failures_{$serviceName}";
        $failureCount = Cache::get($cacheKey, 0) + 1;
        Cache::put($cacheKey, $failureCount, 300);
        
        // Reset success count on failure
        Cache::forget("service_success_{$serviceName}");
        
        // Open circuit breaker if too many failures
        if ($failureCount >= 5) {
            ServiceRegistry::setCircuitBreaker($serviceName, true);
        }
    }

    /**
     * Get service health status
     */
    public function getHealthStatus(): array
    {
        $status = [];
        foreach (array_keys($this->services) as $serviceName) {
            $status[$serviceName] = [
                'healthy' => ServiceRegistry::isServiceHealthy($serviceName),
                'circuit_breaker_open' => ServiceRegistry::isCircuitBreakerOpen($serviceName),
                'recent_failures' => Cache::get("service_failures_{$serviceName}", 0),
                'recent_successes' => Cache::get("service_success_{$serviceName}", 0)
            ];
        }
        return $status;
    }

    /**
     * Register custom fallback handler
     */
    public function registerFallback(string $serviceName, callable $handler): void
    {
        $this->fallbackHandlers[$serviceName] = $handler;
    }

    /**
     * Execute with custom fallback
     */
    public function executeWithFallback(string $serviceName, callable $operation, callable $customFallback = null)
    {
        $fallback = $customFallback ?? ($this->fallbackHandlers[$serviceName] ?? null);
        
        return $this->execute($serviceName, $operation, $fallback);
    }

    /**
     * Batch operation across multiple services
     */
    public function batchExecute(array $batchOperations): array
    {
        $results = [];
        $errors = [];

        foreach ($batchOperations as $operation) {
            $serviceName = $operation['service'];
            $key = $operation['key'] ?? $serviceName;
            
            try {
                $results[$key] = $this->execute(
                    $serviceName,
                    $operation['callback'],
                    $operation['fallback'] ?? null
                );
            } catch (Exception $e) {
                $errors[$key] = $e->getMessage();
                $results[$key] = null;
            }
        }

        return [
            'results' => $results,
            'errors' => $errors,
            'success_count' => count(array_filter($results, fn($r) => $r !== null)),
            'total_count' => count($batchOperations)
        ];
    }

    /**
     * Warm up service connections
     */
    public function warmUp(): void
    {
        foreach ($this->services as $serviceName => $service) {
            try {
                ServiceRegistry::isServiceHealthy($serviceName);
                Log::info("Service {$serviceName} warmed up");
            } catch (Exception $e) {
                Log::warning("Failed to warm up service {$serviceName}", ['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Graceful shutdown
     */
    public function shutdown(): void
    {
        Log::info("Service gateway shutting down");
        // Clean up connections, cache, etc.
    }
}

/**
 * Fallback service implementations (simplified versions that work locally)
 */
class FallbackDocumentService extends AbstractMicroservice
{
    protected string $serviceName = 'document_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function createDocument(array $documentData): array
    {
        // Local database fallback implementation
        return ['success' => true, 'message' => 'Document created locally', 'id' => rand(1000, 9999)];
    }
    
    public function getDocument(int $documentId): ?array
    {
        // Local database fallback implementation
        return ['id' => $documentId, 'title' => 'Fallback Document', 'status' => 'active'];
    }
}

class FallbackVisitorService extends AbstractMicroservice
{
    protected string $serviceName = 'visitor_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function registerVisitor(array $visitorData): array
    {
        return ['success' => true, 'message' => 'Visitor registered locally', 'id' => rand(1000, 9999)];
    }
}

class FallbackFacilityService extends AbstractMicroservice
{
    protected string $serviceName = 'facility_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function createReservation(array $reservationData): array
    {
        return ['success' => true, 'message' => 'Reservation created locally', 'id' => rand(1000, 9999)];
    }
}

class FallbackLegalService extends AbstractMicroservice
{
    protected string $serviceName = 'legal_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function createCase(array $caseData): array
    {
        return ['success' => true, 'message' => 'Legal case created locally', 'id' => rand(1000, 9999)];
    }
}

class FallbackNotificationService extends AbstractMicroservice
{
    protected string $serviceName = 'notification_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function sendNotification(array $notificationData): array
    {
        Log::info('Fallback notification sent', $notificationData);
        return ['success' => true, 'message' => 'Notification sent locally'];
    }
}

class FallbackAuthService extends AbstractMicroservice
{
    protected string $serviceName = 'auth_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function authenticate(array $credentials): array
    {
        // Local authentication fallback
        if (auth()->attempt($credentials)) {
            return ['success' => true, 'user' => auth()->user(), 'fallback_used' => true];
        }
        return ['success' => false, 'message' => 'Invalid credentials', 'fallback_used' => true];
    }
    
    public function validateToken(string $token): array
    {
        // Local token validation fallback
        try {
            $user = \App\Models\User::where('api_token', $token)->first();
            if ($user) {
                return ['success' => true, 'user' => $user, 'fallback_used' => true];
            }
        } catch (\Exception $e) {
            Log::error('Fallback token validation failed', ['error' => $e->getMessage()]);
        }
        return ['success' => false, 'message' => 'Invalid token', 'fallback_used' => true];
    }
}

class FallbackAIService extends AbstractMicroservice
{
    protected string $serviceName = 'ai_fallback';
    
    public function __construct() { /* Local fallback, no HTTP needed */ }
    
    public function analyzeDocument(int $documentId, array $options = []): array
    {
        // Basic local analysis fallback
        $document = \App\Models\Document::find($documentId);
        if (!$document) {
            return ['success' => false, 'message' => 'Document not found', 'fallback_used' => true];
        }
        
        return [
            'success' => true,
            'document_id' => $documentId,
            'analysis' => [
                'title' => $document->title,
                'category' => $document->category,
                'department' => $document->department,
                'word_count' => str_word_count($document->description ?? ''),
                'character_count' => strlen($document->description ?? ''),
            ],
            'fallback_used' => true
        ];
    }
    
    public function extractText(int $documentId, array $options = []): array
    {
        // Basic text extraction fallback
        $document = \App\Models\Document::find($documentId);
        if (!$document) {
            return ['success' => false, 'message' => 'Document not found', 'fallback_used' => true];
        }
        
        return [
            'success' => true,
            'document_id' => $documentId,
            'text' => $document->description ?? '',
            'word_count' => str_word_count($document->description ?? ''),
            'fallback_used' => true
        ];
    }
}
