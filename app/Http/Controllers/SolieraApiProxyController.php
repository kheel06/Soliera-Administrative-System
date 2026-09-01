<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Soliera API Proxy Controller
 * 
 * Token handled server-side to prevent 401 + avoid exposing secrets.
 * All external API calls to Soliera Hotel API are proxied through this controller
 * so the bearer token never needs to be exposed to the browser.
 */
class SolieraApiProxyController extends Controller
{
    private const FACILITY_STATUS_CACHE_TTL_HOURS = 6;

    /**
     * Normalize bearer token - removes "Bearer " prefix if present and trims whitespace
     * FIXED: Use trim() function instead of ->trim() method to prevent "Call to a member function trim() on string" error
     */
    private function normalizeBearerToken(?string $raw): string
    {
        // Type-safe: ensure we have a string before trimming
        $token = trim((string)($raw ?? ''));
        if (empty($token)) {
            return '';
        }
        
        // Remove "Bearer " prefix if present (case-insensitive)
        $tokenStr = (string)$token;
        if (strlen($tokenStr) >= 7 && strtolower(substr($tokenStr, 0, 7)) === 'bearer ') {
            $token = trim(substr($tokenStr, 7));
        }
        
        return $token;
    }

    /**
     * Get API base URL from config
     * Type-safe: ensure string return value
     */
    private function getBaseUrl(): string
    {
        $url = config('services.soliera.base_url') 
            ?: config('services.soliera_hotel_api.base_url')
            ?: 'https://hotel.soliera-hotel-restaurant.com';
        
        return trim((string)$url);
    }

    /**
     * Get API token from config and normalize it
     */
    private function getToken(): string
    {
        $token = config('services.soliera.token') 
            ?: config('services.soliera_hotel_api.token');
        
        return $this->normalizeBearerToken($token);
    }

    /**
     * Build authorization headers with normalized token
     */
    private function getHeaders(): array
    {
        $token = $this->getToken();
        
        if (empty($token)) {
            Log::error('Soliera API token is missing from configuration');
            throw new \RuntimeException('API token not configured');
        }

        // Safe logging: only log token length and preview (first 4 + last 4 chars)
        $tokenPreview = strlen($token) > 8 
            ? substr($token, 0, 4) . '…' . substr($token, -4)
            : '***';
        Log::debug('Soliera API request', [
            'token_length' => strlen($token),
            'token_preview' => $tokenPreview,
        ]);

        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Make HTTP request with retry logic and exponential backoff
     * 
     * @param string $method HTTP method (GET, POST, PUT, etc.)
     * @param string $url Full URL to request
     * @param array $headers Request headers
     * @param array|null $data Request body data (for POST/PUT)
     * @param int $maxRetries Maximum number of retry attempts
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    private function makeRequestWithRetry(string $method, string $url, array $headers, ?array $data = null, int $maxRetries = 3): \Illuminate\Http\Client\Response
    {
        $lastException = null;
        $connectTimeout = 10; // Connection timeout in seconds
        $totalTimeout = 30; // Total request timeout in seconds
        
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $http = Http::withHeaders($headers)
                    ->connectTimeout($connectTimeout)
                    ->timeout($totalTimeout);
                
                // Add jitter to prevent thundering herd (random 0-500ms)
                if ($attempt > 1) {
                    $backoffMs = min(1000 * pow(2, $attempt - 2), 10000); // Exponential backoff, max 10s
                    $jitterMs = rand(0, 500);
                    usleep(($backoffMs + $jitterMs) * 1000);
                }
                
                if ($data !== null) {
                    $response = $http->{strtolower($method)}($url, $data);
                } else {
                    $response = $http->{strtolower($method)}($url);
                }
                
                // If successful (2xx or 3xx), return immediately
                if ($response->successful()) {
                    return $response;
                }
                
                // For 4xx errors (client errors), don't retry
                if ($response->clientError()) {
                    return $response;
                }
                
                // For 5xx errors, log and retry
                Log::warning("Soliera API attempt {$attempt}/{$maxRetries} failed with status {$response->status()}", [
                    'url' => $url,
                    'status' => $response->status(),
                ]);
                
                $lastException = new \RuntimeException("HTTP {$response->status()} from Soliera API");
                
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // Connection/timeout errors - retry
                Log::warning("Soliera API attempt {$attempt}/{$maxRetries} connection failed", [
                    'url' => $url,
                    'error' => $e->getMessage(),
                ]);
                $lastException = $e;
            } catch (\Exception $e) {
                // Other errors - don't retry
                throw $e;
            }
        }
        
        // All retries exhausted
        throw $lastException ?? new \RuntimeException("Failed to connect to Soliera API after {$maxRetries} attempts");
    }

    /**
     * Get cache key for core1events data
     */
    private function getCacheKey(string $suffix = 'data'): string
    {
        return 'soliera_api:core1events:' . $suffix;
    }

    /**
     * Store successful response in cache (both fresh and last-known-good)
     */
    private function cacheResponse(array $data): void
    {
        $ttl = 300; // 5 minutes for fresh data
        $lastKnownGoodKey = $this->getCacheKey('last_known_good');
        
        // Cache fresh data with TTL
        Cache::put($this->getCacheKey('data'), $data, $ttl);
        
        // Always update last-known-good (no expiration)
        Cache::forever($lastKnownGoodKey, $data);
        
        Log::debug('Cached Soliera API response', [
            'ttl' => $ttl,
            'data_keys' => array_keys($data),
        ]);
    }

    /**
     * Get cached response (fresh or last-known-good)
     */
    private function getCachedResponse(): ?array
    {
        // Try fresh cache first
        $fresh = Cache::get($this->getCacheKey('data'));
        if ($fresh !== null) {
            return $fresh;
        }
        
        // Fall back to last-known-good
        $lastKnownGood = Cache::get($this->getCacheKey('last_known_good'));
        return $lastKnownGood;
    }

    /**
     * Generate a unique trace ID for error tracking
     */
    private function generateTraceId(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * Proxy GET request to /api/core1events
     * 
     * GET /internal/soliera/core1events
     * 
     * Resilience features:
     * - Retry with exponential backoff
     * - Caching with TTL
     * - Last-known-good fallback
     * - Structured error responses with trace IDs
     */
    public function getCore1Events(Request $request)
    {
        $traceId = $this->generateTraceId();
        $url = null;
        
        try {
            $baseUrl = $this->getBaseUrl();
            $url = rtrim($baseUrl, '/') . '/api/core1events';
            
            // Attempt to fetch from upstream API
            $response = $this->makeRequestWithRetry('GET', $url, $this->getHeaders());
            
            $statusCode = $response->status();
            $responseData = $response->json();

            // If response is not JSON, return as text
            if ($responseData === null) {
                $responseData = ['raw' => $response->body()];
            }

            // Normalize response: extract events array from various upstream formats
            // Upstream may return: array directly, { data: [...] }, { events: [...] }, etc.
            $eventsArray = null;
            if (is_array($responseData)) {
                // Check if it's a list (numeric keys) - direct array of events
                if (array_is_list($responseData)) {
                    $eventsArray = $responseData;
                } 
                // Check if it's an object with data/events property
                elseif (isset($responseData['data']) && is_array($responseData['data'])) {
                    $eventsArray = $responseData['data'];
                } 
                elseif (isset($responseData['events']) && is_array($responseData['events'])) {
                    $eventsArray = $responseData['events'];
                }
                // Otherwise, wrap the whole response
                else {
                    $eventsArray = $responseData;
                }
            } else {
                // Non-array response, wrap it
                $eventsArray = [$responseData];
            }

            // Ensure we have an array
            if (!is_array($eventsArray)) {
                $eventsArray = [];
            }

            // If successful, cache the events array
            if ($response->successful()) {
                $this->cacheResponse($eventsArray);
                
                // Return in format compatible with frontend: { data: [...], stale: false, ... }
                // Frontend does: data.data || data.events || [] so data.data will work
                return response()->json([
                    'data' => $eventsArray,
                    'stale' => false,
                    'source' => 'upstream',
                    'upstream_ok' => true,
                    'trace_id' => $traceId,
                ], $statusCode);
            }

            // For non-2xx responses, try to return cached data
            $cached = $this->getCachedResponse();
            if ($cached !== null) {
                Log::warning('Soliera API returned non-2xx, serving cached data', [
                    'status' => $statusCode,
                    'trace_id' => $traceId,
                ]);
                
                return response()->json([
                    'data' => $cached,
                    'stale' => true,
                    'source' => 'cache',
                    'upstream_ok' => false,
                    'upstream_status' => $statusCode,
                    'trace_id' => $traceId,
                ], 200);
            }

            // No cache available, return error
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Soliera API',
                'status' => $statusCode,
                'trace_id' => $traceId,
            ], $statusCode);

        } catch (\RuntimeException $e) {
            // Configuration errors - try cache before failing
            $cached = $this->getCachedResponse();
            if ($cached !== null) {
                Log::warning('Configuration error, serving cached data', [
                    'error' => $e->getMessage(),
                    'trace_id' => $traceId,
                ]);
                
                return response()->json([
                    'data' => $cached,
                    'stale' => true,
                    'source' => 'cache',
                    'upstream_ok' => false,
                    'error' => $e->getMessage(),
                    'trace_id' => $traceId,
                ], 200);
            }
            
            Log::error('Soliera API proxy error (config)', [
                'error' => $e->getMessage(),
                'trace_id' => $traceId,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'API configuration error: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
            
        } catch (\Exception $e) {
            // Any other error - try cache before failing
            $cached = $this->getCachedResponse();
            if ($cached !== null) {
                Log::warning('Upstream error, serving cached data', [
                    'error' => $e->getMessage(),
                    'url' => $url ?? 'unknown',
                    'trace_id' => $traceId,
                ]);
                
                return response()->json([
                    'data' => $cached,
                    'stale' => true,
                    'source' => 'cache',
                    'upstream_ok' => false,
                    'error' => $e->getMessage(),
                    'trace_id' => $traceId,
                ], 200);
            }
            
            Log::error('Soliera API proxy error', [
                'error' => $e->getMessage(),
                'url' => $url ?? 'unknown',
                'trace_id' => $traceId,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Soliera API: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
        }
    }

    /**
     * Proxy PUT request to update event status
     * 
     * PUT /internal/soliera/eventapproved/{eventbookingID}
     * Body: { "status": "APPROVED" | "DECLINED" }
     * 
     * Resilience features:
     * - Retry with exponential backoff (for network errors only)
     * - Structured error responses with trace IDs
     * - Type-safe status validation
     */
    public function updateEventStatus(Request $request, string $eventbookingID)
    {
        $traceId = $this->generateTraceId();
        $url = null;
        $status = null;
        
        try {
            // Type-safe: ensure eventbookingID is a string
            $eventbookingID = trim((string)$eventbookingID);
            if (empty($eventbookingID)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event booking ID is required',
                    'trace_id' => $traceId,
                ], 400);
            }

            $baseUrl = $this->getBaseUrl();
            $url = rtrim($baseUrl, '/') . '/api/eventapproved/' . urlencode($eventbookingID);

            // Get status from request body - type-safe
            $status = $request->input('status');
            $status = is_string($status) ? trim($status) : '';
            
            if (empty($status)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status is required',
                    'trace_id' => $traceId,
                ], 400);
            }

            // Validate status value - type-safe
            $validStatuses = ['APPROVED', 'DECLINED', 'COMPLETED', 'DONE'];
            $statusUpper = strtoupper($status);
            if (!in_array($statusUpper, $validStatuses, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid status. Must be one of: ' . implode(', ', $validStatuses),
                    'trace_id' => $traceId,
                ], 400);
            }

            // Use retry logic for PUT requests (idempotent operations can be retried)
            $response = $this->makeRequestWithRetry('PUT', $url, $this->getHeaders(), [
                'status' => $statusUpper,
                'eventstatus' => $statusUpper,
                'bookingStatus' => $statusUpper,
                'reservation_status' => $statusUpper,
            ], 2); // Fewer retries for write operations

            $statusCode = $response->status();
            $responseData = $response->json();

            // If response is not JSON, return as text
            if ($responseData === null) {
                $responseData = ['raw' => $response->body()];
            }

            // Normalize response to array format
            if (!is_array($responseData)) {
                $responseData = ['data' => $responseData];
            }

            // Add trace ID to successful responses
            if (is_array($responseData)) {
                $responseData['trace_id'] = $traceId;
            }

            // Normalize status text for frontend display
            $normalizedStatus = $this->normalizeFacilityStatus($statusUpper);

            // Ensure the response includes the updated status for frontend
            if (!isset($responseData['eventstatus']) && !isset($responseData['status'])) {
                $responseData['eventstatus'] = $normalizedStatus;
                $responseData['status'] = $normalizedStatus;
            }

            // Store local override so UI shows the updated status even if upstream lags
            Cache::put(
                $this->facilityStatusOverrideKey('hotel', $eventbookingID),
                [
                    'status' => $normalizedStatus,
                    'updated_at' => now()->toIso8601String(),
                ],
                now()->addHours(self::FACILITY_STATUS_CACHE_TTL_HOURS)
            );

            return response()->json($responseData, $statusCode);
            
        } catch (\RuntimeException $e) {
            Log::error('Soliera API proxy error (config)', [
                'error' => $e->getMessage(),
                'eventbookingID' => $eventbookingID ?? 'unknown',
                'trace_id' => $traceId,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'API configuration error: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('Soliera API proxy error', [
                'error' => $e->getMessage(),
                'eventbookingID' => $eventbookingID ?? 'unknown',
                'status' => $status ?? 'unknown',
                'url' => $url ?? 'unknown',
                'trace_id' => $traceId,
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event status: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
        }
    }

    /**
     * Get Restaurant API base URL from config
     */
    private function getRestaurantBaseUrl(): string
    {
        $url = config('services.soliera_restaurant.base_url', 'https://restaurant.soliera-hotel-restaurant.com');
        return trim((string)$url);
    }

    /**
     * Get Restaurant API token from config
     */
    private function getRestaurantToken(): string
    {
        $token = config('services.soliera_restaurant.token');
        return $this->normalizeBearerToken($token);
    }

    private function normalizeFacilityStatus(string $status): string
    {
        $upper = strtoupper(trim($status));
        return match ($upper) {
            'APPROVED' => 'Approved',
            'DECLINED' => 'Declined',
            'COMPLETED' => 'Completed',
            'DONE' => 'Done',
            default => ucfirst(strtolower($status)),
        };
    }

    private function facilityStatusOverrideKey(string $source, string $id): string
    {
        return "facility_request_status_override:{$source}:{$id}";
    }

    /**
     * Build authorization headers for Restaurant API
     */
    private function getRestaurantHeaders(): array
    {
        $token = $this->getRestaurantToken();
        
        // Restaurant API may not require token - make it optional
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (!empty($token)) {
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        return $headers;
    }

    /**
     * Proxy GET request to Restaurant API for facility requests
     * 
     * GET /internal/soliera/restaurant/facility-requests
     */
    public function getRestaurantFacilityRequests(Request $request)
    {
        $traceId = $this->generateTraceId();
        $url = null;
        
        try {
            $baseUrl = $this->getRestaurantBaseUrl();
            $endpoint = config('services.soliera_restaurant.facility_request_get', '/API/Event/Event_facility_request_GET.php');
            $url = rtrim($baseUrl, '/') . $endpoint;
            
            Log::info('Fetching Restaurant facility requests', [
                'url' => $url,
                'trace_id' => $traceId,
            ]);

            $response = $this->makeRequestWithRetry('GET', $url, $this->getRestaurantHeaders());
            
            $statusCode = $response->status();
            $responseData = $response->json();

            if ($responseData === null) {
                $responseData = ['raw' => $response->body()];
            }

            // Normalize response to array
            $eventsArray = [];
            if (is_array($responseData)) {
                if (array_is_list($responseData)) {
                    $eventsArray = $responseData;
                } elseif (isset($responseData['data']) && is_array($responseData['data'])) {
                    $eventsArray = $responseData['data'];
                } elseif (isset($responseData['events']) && is_array($responseData['events'])) {
                    $eventsArray = $responseData['events'];
                } elseif (isset($responseData['requests']) && is_array($responseData['requests'])) {
                    $eventsArray = $responseData['requests'];
                } else {
                    $eventsArray = $responseData;
                }
            }

            // Map Restaurant API format to standard format and add source indicator
            $eventsArray = array_map(function($event) {
                if (is_array($event)) {
                    // Map Restaurant API fields to standard format
                    $mapped = [
                        'eventbookingID' => $event['reservation_id'] ?? null,
                        'id' => $event['reservation_id'] ?? null,
                        'eventName' => $event['event_name'] ?? null,
                        'eventType' => $event['event_type'] ?? null,
                        'facilityName' => $event['venue'] ?? null,
                        'facility' => $event['venue'] ?? null,
                        'eventstatus' => $event['reservation_status'] ?? 'Requested',
                        'status' => strtolower($event['reservation_status'] ?? 'pending'),
                        'event_bookedate' => $event['event_date'] ?? null,
                        'event_checkin' => $event['event_date'] ?? null,
                        'event_checkout' => null,
                        'startDate' => $event['event_date'] ?? null,
                        'startTime' => $event['event_time'] ?? null,
                        'contactName' => $event['event_name'] ?? null,
                        'notes' => $event['facility_notes'] ?? null,
                        'facility_notes_parsed' => $event['facility_notes_parsed'] ?? null,
                        'is_upcoming' => $event['is_upcoming'] ?? false,
                        'is_past' => $event['is_past'] ?? false,
                        'days_until_event' => $event['days_until_event'] ?? null,
                        '_source' => 'restaurant',
                        '_source_label' => 'Restaurant',
                        '_raw' => $event, // Keep original data
                    ];
                    return $mapped;
                }
                return $event;
            }, $eventsArray);

            if ($response->successful()) {
                return response()->json([
                    'data' => $eventsArray,
                    'source' => 'restaurant',
                    'upstream_ok' => true,
                    'trace_id' => $traceId,
                ], $statusCode);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Restaurant API',
                'status' => $statusCode,
                'trace_id' => $traceId,
            ], $statusCode);

        } catch (\Exception $e) {
            Log::error('Restaurant API proxy error', [
                'error' => $e->getMessage(),
                'url' => $url ?? 'unknown',
                'trace_id' => $traceId,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch data from Restaurant API: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
        }
    }

    /**
     * Proxy PUT request to update Restaurant facility request status
     * 
     * PUT /internal/soliera/restaurant/facility-requests/{id}
     * Body: { "status": "Approved" | "Declined" | "Done" }
     */
    public function updateRestaurantFacilityRequest(Request $request, string $requestId)
    {
        $traceId = $this->generateTraceId();
        $url = null;
        
        try {
            $requestId = trim((string)$requestId);
            if (empty($requestId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Request ID is required',
                    'trace_id' => $traceId,
                ], 400);
            }

            $baseUrl = $this->getRestaurantBaseUrl();
            $endpoint = config('services.soliera_restaurant.facility_request_put', '/API/Event/Event_facility_request_PUT.php');
            $url = rtrim($baseUrl, '/') . $endpoint;

            $status = $request->input('status');
            $status = is_string($status) ? trim($status) : '';
            
            if (empty($status)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status is required',
                    'trace_id' => $traceId,
                ], 400);
            }

            // Normalize status for Restaurant API
            // Convert "APPROVED" to "Approved", "DECLINED" to "Declined"
            $normalizedStatus = $status;
            if (strtoupper($status) === 'APPROVED') {
                $normalizedStatus = 'Approved';
            } elseif (strtoupper($status) === 'DECLINED') {
                $normalizedStatus = 'Declined';
            } elseif (strtoupper($status) === 'COMPLETED') {
                $normalizedStatus = 'Completed';
            } elseif (strtoupper($status) === 'DONE') {
                $normalizedStatus = 'Done';
            }

            Log::info('Updating Restaurant facility request', [
                'request_id' => $requestId,
                'original_status' => $status,
                'normalized_status' => $normalizedStatus,
                'url' => $url,
                'trace_id' => $traceId,
            ]);

            $response = $this->makeRequestWithRetry('PUT', $url, $this->getRestaurantHeaders(), [
                'id' => $requestId,
                'eventbookingID' => $requestId,
                'status' => $normalizedStatus,
                'eventstatus' => $normalizedStatus,
                'reservation_status' => $normalizedStatus,
            ], 2);

            $statusCode = $response->status();
            $responseData = $response->json();

            if ($responseData === null) {
                $responseData = ['raw' => $response->body()];
            }

            if (!is_array($responseData)) {
                $responseData = ['data' => $responseData];
            }

            $responseData['trace_id'] = $traceId;
            
            // Ensure the response includes the updated status for frontend
            if (!isset($responseData['eventstatus']) && !isset($responseData['status'])) {
                $responseData['eventstatus'] = $normalizedStatus;
                $responseData['status'] = $normalizedStatus;
            }

            // Store local override so UI shows the updated status even if upstream lags
            Cache::put(
                $this->facilityStatusOverrideKey('restaurant', $requestId),
                [
                    'status' => $normalizedStatus,
                    'updated_at' => now()->toIso8601String(),
                ],
                now()->addHours(self::FACILITY_STATUS_CACHE_TTL_HOURS)
            );

            return response()->json($responseData, $statusCode);
            
        } catch (\Exception $e) {
            Log::error('Restaurant API proxy error', [
                'error' => $e->getMessage(),
                'request_id' => $requestId ?? 'unknown',
                'url' => $url ?? 'unknown',
                'trace_id' => $traceId,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update request status: ' . $e->getMessage(),
                'trace_id' => $traceId,
            ], 500);
        }
    }

    /**
     * Get combined facility requests from both Hotel and Restaurant APIs
     * 
     * GET /internal/soliera/combined/facility-requests
     */
    public function getCombinedFacilityRequests(Request $request)
    {
        $traceId = $this->generateTraceId();
        $hotelData = [];
        $restaurantData = [];
        $errors = [];

        // Fetch from Hotel API
        try {
            $baseUrl = $this->getBaseUrl();
            $url = rtrim($baseUrl, '/') . '/api/core1events';
            $response = $this->makeRequestWithRetry('GET', $url, $this->getHeaders());
            
            if ($response->successful()) {
                $data = $response->json();
                $hotelData = is_array($data) ? (array_is_list($data) ? $data : ($data['data'] ?? $data['events'] ?? [])) : [];
                
                // Add source indicator
                $hotelData = array_map(function($event) {
                    if (is_array($event)) {
                        $eventId = $event['eventbookingID'] ?? $event['id'] ?? null;
                        if ($eventId) {
                            $override = Cache::get($this->facilityStatusOverrideKey('hotel', $eventId));
                            if ($override && !empty($override['status'])) {
                                $event['eventstatus'] = $override['status'];
                                $event['status'] = strtolower($override['status']);
                                $event['bookingStatus'] = strtolower($override['status']);
                            }
                        }
                        $event['_source'] = 'hotel';
                        $event['_source_label'] = 'Hotel';
                    }
                    return $event;
                }, $hotelData);
            }
        } catch (\Exception $e) {
            $errors[] = ['source' => 'hotel', 'error' => $e->getMessage()];
            Log::warning('Failed to fetch Hotel facility requests', ['error' => $e->getMessage()]);
        }

        // Fetch from Restaurant API
        try {
            $baseUrl = $this->getRestaurantBaseUrl();
            $endpoint = config('services.soliera_restaurant.facility_request_get', '/API/Event/Event_facility_request_GET.php');
            $url = rtrim($baseUrl, '/') . $endpoint;
            $response = $this->makeRequestWithRetry('GET', $url, $this->getRestaurantHeaders());
            
            if ($response->successful()) {
                $data = $response->json();
                $rawData = is_array($data) ? (array_is_list($data) ? $data : ($data['data'] ?? $data['events'] ?? $data['requests'] ?? [])) : [];
                
                // Map Restaurant API format to standard format
                $restaurantData = array_map(function($event) {
                    if (is_array($event)) {
                        $eventId = $event['reservation_id'] ?? null;
                        $override = $eventId ? Cache::get($this->facilityStatusOverrideKey('restaurant', $eventId)) : null;
                        $overrideStatus = $override['status'] ?? null;
                        return [
                            'eventbookingID' => $event['reservation_id'] ?? null,
                            'id' => $event['reservation_id'] ?? null,
                            'eventName' => $event['event_name'] ?? null,
                            'eventType' => $event['event_type'] ?? null,
                            'facilityName' => $event['venue'] ?? null,
                            'facility' => $event['venue'] ?? null,
                            'eventstatus' => $overrideStatus ?: ($event['reservation_status'] ?? 'Requested'),
                            'status' => strtolower($overrideStatus ?: ($event['reservation_status'] ?? 'pending')),
                            'event_bookedate' => $event['event_date'] ?? null,
                            'event_checkin' => $event['event_date'] ?? null,
                            'event_checkout' => null,
                            'startDate' => $event['event_date'] ?? null,
                            'startTime' => $event['event_time'] ?? null,
                            'contactName' => $event['event_name'] ?? null,
                            'notes' => $event['facility_notes'] ?? null,
                            'facility_notes_parsed' => $event['facility_notes_parsed'] ?? null,
                            'is_upcoming' => $event['is_upcoming'] ?? false,
                            'is_past' => $event['is_past'] ?? false,
                            'days_until_event' => $event['days_until_event'] ?? null,
                            '_source' => 'restaurant',
                            '_source_label' => 'Restaurant',
                            '_raw' => $event,
                        ];
                    }
                    return $event;
                }, $rawData);
            }
        } catch (\Exception $e) {
            $errors[] = ['source' => 'restaurant', 'error' => $e->getMessage()];
            Log::warning('Failed to fetch Restaurant facility requests', ['error' => $e->getMessage()]);
        }

        // Combine both arrays
        $combined = array_merge($hotelData, $restaurantData);

        return response()->json([
            'data' => $combined,
            'sources' => [
                'hotel' => ['count' => count($hotelData), 'ok' => empty(array_filter($errors, fn($e) => $e['source'] === 'hotel'))],
                'restaurant' => ['count' => count($restaurantData), 'ok' => empty(array_filter($errors, fn($e) => $e['source'] === 'restaurant'))],
            ],
            'errors' => $errors,
            'trace_id' => $traceId,
        ], 200);
    }
}
