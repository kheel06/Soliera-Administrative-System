<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Microservice Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for microservice architecture including service URLs,
    | authentication, timeouts, and other service-specific settings.
    |
    */

    'document' => [
        'url' => env('DOCUMENT_SERVICE_URL', 'http://localhost:8001'),
        'api_key' => env('DOCUMENT_SERVICE_API_KEY'),
        'timeout' => env('DOCUMENT_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('DOCUMENT_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('DOCUMENT_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('DOCUMENT_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('DOCUMENT_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'visitor' => [
        'url' => env('VISITOR_SERVICE_URL', 'http://localhost:8002'),
        'api_key' => env('VISITOR_SERVICE_API_KEY'),
        'timeout' => env('VISITOR_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('VISITOR_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('VISITOR_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('VISITOR_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('VISITOR_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'facility' => [
        'url' => env('FACILITY_SERVICE_URL', 'http://localhost:8003'),
        'api_key' => env('FACILITY_SERVICE_API_KEY'),
        'timeout' => env('FACILITY_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('FACILITY_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('FACILITY_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('FACILITY_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('FACILITY_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'legal' => [
        'url' => env('LEGAL_SERVICE_URL', 'http://localhost:8004'),
        'api_key' => env('LEGAL_SERVICE_API_KEY'),
        'timeout' => env('LEGAL_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('LEGAL_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('LEGAL_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('LEGAL_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('LEGAL_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'notification' => [
        'url' => env('NOTIFICATION_SERVICE_URL', 'http://localhost:8005'),
        'api_key' => env('NOTIFICATION_SERVICE_API_KEY'),
        'timeout' => env('NOTIFICATION_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('NOTIFICATION_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('NOTIFICATION_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('NOTIFICATION_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('NOTIFICATION_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'auth' => [
        'url' => env('AUTH_SERVICE_URL', 'http://localhost:8006'),
        'api_key' => env('AUTH_SERVICE_API_KEY'),
        'timeout' => env('AUTH_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('AUTH_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('AUTH_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('AUTH_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('AUTH_SERVICE_CIRCUIT_TIMEOUT', 300),
    ],

    'ai' => [
        'url' => env('AI_SERVICE_URL', 'http://localhost:8007'),
        'api_key' => env('AI_SERVICE_API_KEY'),
        'timeout' => env('AI_SERVICE_TIMEOUT', 60), // AI operations may take longer
        'retry_attempts' => env('AI_SERVICE_RETRY_ATTEMPTS', 2),
        'health_check_interval' => env('AI_SERVICE_HEALTH_CHECK', 120),
        'circuit_breaker_threshold' => env('AI_SERVICE_CIRCUIT_THRESHOLD', 3),
        'circuit_breaker_timeout' => env('AI_SERVICE_CIRCUIT_TIMEOUT', 600),
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Microservice Settings
    |--------------------------------------------------------------------------
    */
    'global' => [
        'default_timeout' => env('MICROSERVICE_DEFAULT_TIMEOUT', 30),
        'default_retry_attempts' => env('MICROSERVICE_DEFAULT_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('MICROSERVICE_HEALTH_CHECK_INTERVAL', 60),
        'circuit_breaker_threshold' => env('MICROSERVICE_CIRCUIT_BREAKER_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('MICROSERVICE_CIRCUIT_BREAKER_TIMEOUT', 300),
        'enable_fallback' => env('MICROSERVICE_ENABLE_FALLBACK', true),
        'log_requests' => env('MICROSERVICE_LOG_REQUESTS', true),
        'cache_responses' => env('MICROSERVICE_CACHE_RESPONSES', true),
        'cache_ttl' => env('MICROSERVICE_CACHE_TTL', 300),
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Discovery
    |--------------------------------------------------------------------------
    */
    'discovery' => [
        'enabled' => env('MICROSERVICE_DISCOVERY_ENABLED', false),
        'type' => env('MICROSERVICE_DISCOVERY_TYPE', 'consul'), // consul, etcd, custom
        'host' => env('MICROSERVICE_DISCOVERY_HOST', 'localhost'),
        'port' => env('MICROSERVICE_DISCOVERY_PORT', 8500),
        'health_check_path' => '/health',
        'deregister_critical_service_after' => '30s',
        'check_interval' => '10s',
    ],

    /*
    |--------------------------------------------------------------------------
    | Load Balancing
    |--------------------------------------------------------------------------
    */
    'load_balancing' => [
        'enabled' => env('MICROSERVICE_LOAD_BALANCING_ENABLED', false),
        'strategy' => env('MICROSERVICE_LOAD_BALANCING_STRATEGY', 'round_robin'), // round_robin, random, weighted
        'instances' => [
            // Define multiple instances for each service
            // 'document' => [
            //     ['url' => 'http://localhost:8001', 'weight' => 1],
            //     ['url' => 'http://localhost:8008', 'weight' => 1],
            // ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring and Metrics
    |--------------------------------------------------------------------------
    */
    'monitoring' => [
        'enabled' => env('MICROSERVICE_MONITORING_ENABLED', true),
        'metrics_endpoint' => env('MICROSERVICE_METRICS_ENDPOINT', '/metrics'),
        'collect_response_times' => env('MICROSERVICE_COLLECT_RESPONSE_TIMES', true),
        'collect_error_rates' => env('MICROSERVICE_COLLECT_ERROR_RATES', true),
        'collect_circuit_breaker_events' => env('MICROSERVICE_COLLECT_CIRCUIT_BREAKER_EVENTS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */
    'security' => [
        'require_https' => env('MICROSERVICE_REQUIRE_HTTPS', false),
        'verify_ssl' => env('MICROSERVICE_VERIFY_SSL', true),
        'shared_secret' => env('MICROSERVICE_SHARED_SECRET'),
        'jwt_secret' => env('MICROSERVICE_JWT_SECRET'),
        'rate_limiting' => [
            'enabled' => env('MICROSERVICE_RATE_LIMITING_ENABLED', true),
            'requests_per_minute' => env('MICROSERVICE_RATE_LIMIT', 60),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Settings
    |--------------------------------------------------------------------------
    */
    'development' => [
        'mock_services' => env('MICROSERVICE_MOCK_SERVICES', false),
        'local_fallback' => env('MICROSERVICE_LOCAL_FALLBACK', true),
        'debug_mode' => env('MICROSERVICE_DEBUG_MODE', env('APP_DEBUG', false)),
        'simulate_failures' => env('MICROSERVICE_SIMULATE_FAILURES', false),
        'failure_rate' => env('MICROSERVICE_FAILURE_RATE', 0), // 0-100 percentage
    ],
];
