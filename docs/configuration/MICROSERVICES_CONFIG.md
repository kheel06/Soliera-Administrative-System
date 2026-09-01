# Microservices Configuration Guide

## Overview

This guide provides detailed configuration instructions for the microservice architecture in the Hotel & Restaurant Administrative Management System.

## Environment Configuration

### Required Environment Variables

Create or update your `.env` file with the following variables:

```env
# ==========================================
# MICROSERVICE CORE CONFIGURATION
# ==========================================

# Enable/disable microservice architecture
MICROSERVICE_ENABLED=true

# Enable fallback to local implementations
MICROSERVICE_ENABLE_FALLBACK=true

# Enable request/response logging
MICROSERVICE_LOG_REQUESTS=true

# Enable response caching
MICROSERVICE_CACHE_RESPONSES=true

# Default cache TTL (seconds)
MICROSERVICE_CACHE_TTL=300

# Default timeout (seconds)
MICROSERVICE_DEFAULT_TIMEOUT=30

# Default retry attempts
MICROSERVICE_DEFAULT_RETRY_ATTEMPTS=3

# Health check interval (seconds)
MICROSERVICE_HEALTH_CHECK_INTERVAL=60

# Circuit breaker threshold (failures before opening)
MICROSERVICE_CIRCUIT_BREAKER_THRESHOLD=5

# Circuit breaker timeout (seconds)
MICROSERVICE_CIRCUIT_BREAKER_TIMEOUT=300

# ==========================================
# INDIVIDUAL SERVICE CONFIGURATION
# ==========================================

# Document Service
DOCUMENT_SERVICE_URL=http://localhost:8001
DOCUMENT_SERVICE_API_KEY=your_document_service_key_here
DOCUMENT_SERVICE_TIMEOUT=30
DOCUMENT_SERVICE_RETRY_ATTEMPTS=3
DOCUMENT_SERVICE_HEALTH_CHECK=60
DOCUMENT_SERVICE_CIRCUIT_THRESHOLD=5
DOCUMENT_SERVICE_CIRCUIT_TIMEOUT=300

# Visitor Service
VISITOR_SERVICE_URL=http://localhost:8002
VISITOR_SERVICE_API_KEY=your_visitor_service_key_here
VISITOR_SERVICE_TIMEOUT=30
VISITOR_SERVICE_RETRY_ATTEMPTS=3
VISITOR_SERVICE_HEALTH_CHECK=60
VISITOR_SERVICE_CIRCUIT_THRESHOLD=5
VISITOR_SERVICE_CIRCUIT_TIMEOUT=300

# Facility Service
FACILITY_SERVICE_URL=http://localhost:8003
FACILITY_SERVICE_API_KEY=your_facility_service_key_here
FACILITY_SERVICE_TIMEOUT=30
FACILITY_SERVICE_RETRY_ATTEMPTS=3
FACILITY_SERVICE_HEALTH_CHECK=60
FACILITY_SERVICE_CIRCUIT_THRESHOLD=5
FACILITY_SERVICE_CIRCUIT_TIMEOUT=300

# Legal Service
LEGAL_SERVICE_URL=http://localhost:8004
LEGAL_SERVICE_API_KEY=your_legal_service_key_here
LEGAL_SERVICE_TIMEOUT=30
LEGAL_SERVICE_RETRY_ATTEMPTS=3
LEGAL_SERVICE_HEALTH_CHECK=60
LEGAL_SERVICE_CIRCUIT_THRESHOLD=5
LEGAL_SERVICE_CIRCUIT_TIMEOUT=300

# Notification Service
NOTIFICATION_SERVICE_URL=http://localhost:8005
NOTIFICATION_SERVICE_API_KEY=your_notification_service_key_here
NOTIFICATION_SERVICE_TIMEOUT=30
NOTIFICATION_SERVICE_RETRY_ATTEMPTS=3
NOTIFICATION_SERVICE_HEALTH_CHECK=60
NOTIFICATION_SERVICE_CIRCUIT_THRESHOLD=5
NOTIFICATION_SERVICE_CIRCUIT_TIMEOUT=300

# Authentication Service
AUTH_SERVICE_URL=http://localhost:8006
AUTH_SERVICE_API_KEY=your_auth_service_key_here
AUTH_SERVICE_TIMEOUT=30
AUTH_SERVICE_RETRY_ATTEMPTS=3
AUTH_SERVICE_HEALTH_CHECK=60
AUTH_SERVICE_CIRCUIT_THRESHOLD=5
AUTH_SERVICE_CIRCUIT_TIMEOUT=300

# AI Service
AI_SERVICE_URL=http://localhost:8007
AI_SERVICE_API_KEY=your_ai_service_key_here
AI_SERVICE_TIMEOUT=60
AI_SERVICE_RETRY_ATTEMPTS=2
AI_SERVICE_HEALTH_CHECK=120
AI_SERVICE_CIRCUIT_THRESHOLD=3
AI_SERVICE_CIRCUIT_TIMEOUT=600

# ==========================================
# SERVICE DISCOVERY CONFIGURATION
# ==========================================

# Enable service discovery
MICROSERVICE_DISCOVERY_ENABLED=false

# Discovery service type (consul, etcd, custom)
MICROSERVICE_DISCOVERY_TYPE=consul

# Discovery service host
MICROSERVICE_DISCOVERY_HOST=localhost

# Discovery service port
MICROSERVICE_DISCOVERY_PORT=8500

# Health check path
MICROSERVICE_DISCOVERY_HEALTH_CHECK_PATH=/health

# Deregister critical service after
MICROSERVICE_DISCOVERY_DEREGISTER_CRITICAL=30s

# Check interval
MICROSERVICE_DISCOVERY_CHECK_INTERVAL=10s

# ==========================================
# LOAD BALANCING CONFIGURATION
# ==========================================

# Enable load balancing
MICROSERVICE_LOAD_BALANCING_ENABLED=false

# Load balancing strategy (round_robin, random, weighted)
MICROSERVICE_LOAD_BALANCING_STRATEGY=round_robin

# ==========================================
# MONITORING CONFIGURATION
# ==========================================

# Enable monitoring
MICROSERVICE_MONITORING_ENABLED=true

# Metrics endpoint
MICROSERVICE_METRICS_ENDPOINT=/metrics

# Collect response times
MICROSERVICE_COLLECT_RESPONSE_TIMES=true

# Collect error rates
MICROSERVICE_COLLECT_ERROR_RATES=true

# Collect circuit breaker events
MICROSERVICE_COLLECT_CIRCUIT_BREAKER_EVENTS=true

# ==========================================
# SECURITY CONFIGURATION
# ==========================================

# Require HTTPS for service communication
MICROSERVICE_REQUIRE_HTTPS=false

# Verify SSL certificates
MICROSERVICE_VERIFY_SSL=true

# Shared secret for service authentication
MICROSERVICE_SHARED_SECRET=your_shared_secret_here

# JWT secret for token authentication
MICROSERVICE_JWT_SECRET=your_jwt_secret_here

# Enable rate limiting
MICROSERVICE_RATE_LIMITING_ENABLED=true

# Rate limit (requests per minute)
MICROSERVICE_RATE_LIMIT=60

# ==========================================
# DEVELOPMENT CONFIGURATION
# ==========================================

# Enable mock services for testing
MICROSERVICE_MOCK_SERVICES=false

# Enable local fallback
MICROSERVICE_LOCAL_FALLBACK=true

# Enable debug mode
MICROSERVICE_DEBUG_MODE=false

# Simulate service failures (for testing)
MICROSERVICE_SIMULATE_FAILURES=false

# Failure simulation rate (0-100)
MICROSERVICE_FAILURE_RATE=0

# ==========================================
# PERFORMANCE CONFIGURATION
# ==========================================

# Connection pool size
MICROSERVICE_CONNECTION_POOL_SIZE=10

# Connection timeout
MICROSERVICE_CONNECTION_TIMEOUT=5

# Read timeout
MICROSERVICE_READ_TIMEOUT=30

# Write timeout
MICROSERVICE_WRITE_TIMEOUT=30

# Enable HTTP/2
MICROSERVICE_ENABLE_HTTP2=true

# Enable compression
MICROSERVICE_ENABLE_COMPRESSION=true

# ==========================================
# CACHING CONFIGURATION
# ==========================================

# Cache driver (redis, memcached, database, file)
MICROSERVICE_CACHE_DRIVER=redis

# Cache prefix
MICROSERVICE_CACHE_PREFIX=microservices

# Cache TTL for responses (seconds)
MICROSERVICE_RESPONSE_CACHE_TTL=300

# Cache TTL for health checks (seconds)
MICROSERVICE_HEALTH_CACHE_TTL=60

# Maximum cache size (MB)
MICROSERVICE_MAX_CACHE_SIZE=100
```

## Configuration File

The main configuration is located in `config/microservices.php`. Here's the complete configuration:

```php
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
        'endpoints' => [
            'health' => '/health',
            'documents' => '/documents',
            'import' => '/documents/import',
            'analytics' => '/documents/analytics',
        ],
        'features' => [
            'ai_processing' => true,
            'text_extraction' => true,
            'workflow_automation' => true,
        ],
    ],

    'visitor' => [
        'url' => env('VISITOR_SERVICE_URL', 'http://localhost:8002'),
        'api_key' => env('VISITOR_SERVICE_API_KEY'),
        'timeout' => env('VISITOR_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('VISITOR_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('VISITOR_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('VISITOR_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('VISITOR_SERVICE_CIRCUIT_TIMEOUT', 300),
        'endpoints' => [
            'health' => '/health',
            'visitors' => '/visitors',
            'check_in' => '/visitors/{id}/check-in',
            'check_out' => '/visitors/{id}/check-out',
            'qr_pass' => '/visitors/{id}/qr-pass',
        ],
        'features' => [
            'qr_generation' => true,
            'biometric_verification' => false,
            'pre_registration' => true,
        ],
    ],

    'facility' => [
        'url' => env('FACILITY_SERVICE_URL', 'http://localhost:8003'),
        'api_key' => env('FACILITY_SERVICE_API_KEY'),
        'timeout' => env('FACILITY_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('FACILITY_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('FACILITY_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('FACILITY_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('FACILITY_SERVICE_CIRCUIT_TIMEOUT', 300),
        'endpoints' => [
            'health' => '/health',
            'facilities' => '/facilities',
            'reservations' => '/reservations',
            'availability' => '/facilities/{id}/availability',
            'calendar' => '/facilities/{id}/calendar',
        ],
        'features' => [
            'auto_scheduling' => true,
            'resource_optimization' => true,
            'maintenance_tracking' => true,
        ],
    ],

    'legal' => [
        'url' => env('LEGAL_SERVICE_URL', 'http://localhost:8004'),
        'api_key' => env('LEGAL_SERVICE_API_KEY'),
        'timeout' => env('LEGAL_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('LEGAL_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('LEGAL_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('LEGAL_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('LEGAL_SERVICE_CIRCUIT_TIMEOUT', 300),
        'endpoints' => [
            'health' => '/health',
            'cases' => '/legal/cases',
            'documents' => '/legal/documents',
            'analytics' => '/legal/analytics',
            'compliance' => '/legal/compliance',
        ],
        'features' => [
            'risk_assessment' => true,
            'compliance_monitoring' => true,
            'document_analysis' => true,
        ],
    ],

    'notification' => [
        'url' => env('NOTIFICATION_SERVICE_URL', 'http://localhost:8005'),
        'api_key' => env('NOTIFICATION_SERVICE_API_KEY'),
        'timeout' => env('NOTIFICATION_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('NOTIFICATION_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('NOTIFICATION_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('NOTIFICATION_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('NOTIFICATION_SERVICE_CIRCUIT_TIMEOUT', 300),
        'endpoints' => [
            'health' => '/health',
            'notifications' => '/notifications',
            'email' => '/notifications/email',
            'sms' => '/notifications/sms',
            'push' => '/notifications/push',
        ],
        'features' => [
            'email_notifications' => true,
            'sms_notifications' => true,
            'push_notifications' => true,
            'webhook_support' => true,
        ],
    ],

    'auth' => [
        'url' => env('AUTH_SERVICE_URL', 'http://localhost:8006'),
        'api_key' => env('AUTH_SERVICE_API_KEY'),
        'timeout' => env('AUTH_SERVICE_TIMEOUT', 30),
        'retry_attempts' => env('AUTH_SERVICE_RETRY_ATTEMPTS', 3),
        'health_check_interval' => env('AUTH_SERVICE_HEALTH_CHECK', 60),
        'circuit_breaker_threshold' => env('AUTH_SERVICE_CIRCUIT_THRESHOLD', 5),
        'circuit_breaker_timeout' => env('AUTH_SERVICE_CIRCUIT_TIMEOUT', 300),
        'endpoints' => [
            'health' => '/health',
            'authenticate' => '/auth/authenticate',
            'authorize' => '/auth/authorize',
            'tokens' => '/auth/tokens',
            'users' => '/auth/users',
        ],
        'features' => [
            'jwt_tokens' => true,
            'oauth2_support' => true,
            'multi_factor_auth' => false,
        ],
    ],

    'ai' => [
        'url' => env('AI_SERVICE_URL', 'http://localhost:8007'),
        'api_key' => env('AI_SERVICE_API_KEY'),
        'timeout' => env('AI_SERVICE_TIMEOUT', 60),
        'retry_attempts' => env('AI_SERVICE_RETRY_ATTEMPTS', 2),
        'health_check_interval' => env('AI_SERVICE_HEALTH_CHECK', 120),
        'circuit_breaker_threshold' => env('AI_SERVICE_CIRCUIT_THRESHOLD', 3),
        'circuit_breaker_timeout' => env('AI_SERVICE_CIRCUIT_TIMEOUT', 600),
        'endpoints' => [
            'health' => '/health',
            'analyze' => '/ai/analyze',
            'process' => '/ai/process',
            'classify' => '/ai/classify',
            'extract' => '/ai/extract',
        ],
        'features' => [
            'document_analysis' => true,
            'text_extraction' => true,
            'sentiment_analysis' => true,
            'entity_recognition' => true,
        ],
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
        'type' => env('MICROSERVICE_DISCOVERY_TYPE', 'consul'),
        'host' => env('MICROSERVICE_DISCOVERY_HOST', 'localhost'),
        'port' => env('MICROSERVICE_DISCOVERY_PORT', 8500),
        'health_check_path' => '/health',
        'deregister_critical_service_after' => '30s',
        'check_interval' => '10s',
        'tags' => ['laravel', 'admin-system'],
        'meta' => [
            'version' => '1.0.0',
            'environment' => env('APP_ENV', 'production'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Load Balancing
    |--------------------------------------------------------------------------
    */
    'load_balancing' => [
        'enabled' => env('MICROSERVICE_LOAD_BALANCING_ENABLED', false),
        'strategy' => env('MICROSERVICE_LOAD_BALANCING_STRATEGY', 'round_robin'),
        'instances' => [
            // Define multiple instances for each service
            // 'document' => [
            //     ['url' => 'http://localhost:8001', 'weight' => 1],
            //     ['url' => 'http://localhost:8008', 'weight' => 1],
            // ],
        ],
        'health_check_interval' => 30,
        'unhealthy_threshold' => 3,
        'healthy_threshold' => 2,
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
        'prometheus_enabled' => env('MICROSERVICE_PROMETHEUS_ENABLED', false),
        'prometheus_port' => env('MICROSERVICE_PROMETHEUS_PORT', 9090),
        'grafana_enabled' => env('MICROSERVICE_GRAFANA_ENABLED', false),
        'grafana_url' => env('MICROSERVICE_GRAFANA_URL', 'http://localhost:3000'),
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
            'burst_size' => env('MICROSERVICE_RATE_LIMIT_BURST', 10),
        ],
        'authentication' => [
            'type' => env('MICROSERVICE_AUTH_TYPE', 'bearer'), // bearer, jwt, basic
            'header_name' => env('MICROSERVICE_AUTH_HEADER', 'Authorization'),
            'token_prefix' => env('MICROSERVICE_TOKEN_PREFIX', 'Bearer'),
        ],
        'encryption' => [
            'enabled' => env('MICROSERVICE_ENCRYPTION_ENABLED', false),
            'algorithm' => env('MICROSERVICE_ENCRYPTION_ALGORITHM', 'AES-256-GCM'),
            'key' => env('MICROSERVICE_ENCRYPTION_KEY'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance
    |--------------------------------------------------------------------------
    */
    'performance' => [
        'connection_pool_size' => env('MICROSERVICE_CONNECTION_POOL_SIZE', 10),
        'connection_timeout' => env('MICROSERVICE_CONNECTION_TIMEOUT', 5),
        'read_timeout' => env('MICROSERVICE_READ_TIMEOUT', 30),
        'write_timeout' => env('MICROSERVICE_WRITE_TIMEOUT', 30),
        'enable_http2' => env('MICROSERVICE_ENABLE_HTTP2', true),
        'enable_compression' => env('MICROSERVICE_ENABLE_COMPRESSION', true),
        'compression_level' => env('MICROSERVICE_COMPRESSION_LEVEL', 6),
        'keep_alive' => env('MICROSERVICE_KEEP_ALIVE', true),
        'max_redirects' => env('MICROSERVICE_MAX_REDIRECTS', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    */
    'caching' => [
        'driver' => env('MICROSERVICE_CACHE_DRIVER', 'redis'),
        'prefix' => env('MICROSERVICE_CACHE_PREFIX', 'microservices'),
        'response_ttl' => env('MICROSERVICE_RESPONSE_CACHE_TTL', 300),
        'health_ttl' => env('MICROSERVICE_HEALTH_CACHE_TTL', 60),
        'max_size' => env('MICROSERVICE_MAX_CACHE_SIZE', 100), // MB
        'tags' => ['microservices'],
        'serialize' => true,
        'compress' => env('MICROSERVICE_CACHE_COMPRESS', false),
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
        'log_level' => env('MICROSERVICE_LOG_LEVEL', 'info'),
        'slow_query_threshold' => env('MICROSERVICE_SLOW_QUERY_THRESHOLD', 1000), // ms
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => env('MICROSERVICE_LOGGING_ENABLED', true),
        'channel' => env('MICROSERVICE_LOG_CHANNEL', 'microservices'),
        'level' => env('MICROSERVICE_LOG_LEVEL', 'info'),
        'max_files' => env('MICROSERVICE_LOG_MAX_FILES', 30),
        'format' => env('MICROSERVICE_LOG_FORMAT', 'json'),
        'include_request_data' => env('MICROSERVICE_LOG_REQUESTS', true),
        'include_response_data' => env('MICROSERVICE_LOG_RESPONSES', false),
        'sanitize_sensitive_data' => env('MICROSERVICE_LOG_SANITIZE', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    'events' => [
        'enabled' => env('MICROSERVICE_EVENTS_ENABLED', false),
        'driver' => env('MICROSERVICE_EVENTS_DRIVER', 'redis'),
        'queue_name' => env('MICROSERVICE_EVENTS_QUEUE', 'microservice_events'),
        'retry_after' => env('MICROSERVICE_EVENTS_RETRY_AFTER', 90),
        'max_tries' => env('MICROSERVICE_EVENTS_MAX_TRIES', 3),
        'events' => [
            'service.health_changed',
            'service.error',
            'circuit_breaker.opened',
            'circuit_breaker.closed',
            'fallback.activated',
        ],
    ],
];
```

## Configuration Validation

### Validate Configuration

Use the built-in configuration validator:

```bash
php artisan microservice:config:validate
```

### Check Specific Service

```bash
php artisan microservice:config:check document
```

### Show Configuration

```bash
# Show all configuration
php artisan config:show microservices

# Show specific service configuration
php artisan microservice:config:show document
```

## Environment-Specific Configurations

### Development Environment

```env
APP_ENV=local
MICROSERVICE_MOCK_SERVICES=true
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=true
MICROSERVICE_LOG_LEVEL=debug
MICROSERVICE_SIMULATE_FAILURES=true
MICROSERVICE_FAILURE_RATE=10
```

### Testing Environment

```env
APP_ENV=testing
MICROSERVICE_MOCK_SERVICES=true
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=true
MICROSERVICE_CACHE_RESPONSES=false
MICROSERVICE_LOG_REQUESTS=false
```

### Staging Environment

```env
APP_ENV=staging
MICROSERVICE_MOCK_SERVICES=false
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=false
MICROSERVICE_REQUIRE_HTTPS=true
MICROSERVICE_VERIFY_SSL=true
```

### Production Environment

```env
APP_ENV=production
MICROSERVICE_MOCK_SERVICES=false
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=false
MICROSERVICE_REQUIRE_HTTPS=true
MICROSERVICE_VERIFY_SSL=true
MICROSERVICE_LOG_LEVEL=warning
MICROSERVICE_MONITORING_ENABLED=true
```

## Service-Specific Configuration

### Document Service Configuration

```php
'document' => [
    'url' => env('DOCUMENT_SERVICE_URL'),
    'api_key' => env('DOCUMENT_SERVICE_API_KEY'),
    'timeout' => env('DOCUMENT_SERVICE_TIMEOUT', 30),
    'features' => [
        'ai_processing' => true,
        'text_extraction' => true,
        'workflow_automation' => true,
        'version_control' => true,
        'collaboration' => false,
    ],
    'limits' => [
        'max_file_size' => 50 * 1024 * 1024, // 50MB
        'allowed_formats' => ['pdf', 'doc', 'docx', 'txt'],
        'max_uploads_per_day' => 1000,
    ],
    'processing' => [
        'async_processing' => true,
        'queue_name' => 'document_processing',
        'retry_attempts' => 3,
        'timeout' => 300, // 5 minutes
    ],
],
```

### Visitor Service Configuration

```php
'visitor' => [
    'url' => env('VISITOR_SERVICE_URL'),
    'api_key' => env('VISITOR_SERVICE_API_KEY'),
    'features' => [
        'qr_generation' => true,
        'biometric_verification' => false,
        'pre_registration' => true,
        'bulk_registration' => true,
    ],
    'security' => [
        'max_visitors_per_day' => 1000,
        'blacklist_enabled' => true,
        'id_verification_required' => true,
    ],
    'notifications' => [
        'check_in_notifications' => true,
        'check_out_reminders' => true,
        'security_alerts' => true,
    ],
],
```

## Troubleshooting Configuration

### Common Configuration Issues

1. **Service URLs Incorrect**
   ```bash
   # Test service connectivity
   php artisan microservice:test document
   ```

2. **API Keys Missing**
   ```bash
   # Check required environment variables
   php artisan env | grep SERVICE_API_KEY
   ```

3. **Timeout Values Too Low**
   ```bash
   # Check timeout configuration
   php artisan microservice:config:show document | grep timeout
   ```

4. **Circuit Breaker Too Sensitive**
   ```bash
   # Adjust circuit breaker threshold
   MICROSERVICE_CIRCUIT_BREAKER_THRESHOLD=10
   ```

### Configuration Debugging

Enable debug mode to get detailed configuration information:

```env
MICROSERVICE_DEBUG_MODE=true
```

Check configuration logs:

```bash
tail -f storage/logs/microservices.log | grep "config"
```

## Performance Tuning

### Optimize for High Traffic

```env
# Increase connection pool size
MICROSERVICE_CONNECTION_POOL_SIZE=50

# Enable HTTP/2 and compression
MICROSERVICE_ENABLE_HTTP2=true
MICROSERVICE_ENABLE_COMPRESSION=true

# Optimize timeouts
MICROSERVICE_CONNECTION_TIMEOUT=2
MICROSERVICE_READ_TIMEOUT=15
MICROSERVICE_WRITE_TIMEOUT=15

# Enable aggressive caching
MICROSERVICE_CACHE_RESPONSES=true
MICROSERVICE_CACHE_TTL=600
```

### Optimize for Low Latency

```env
# Reduce timeouts for fast responses
MICROSERVICE_DEFAULT_TIMEOUT=10
MICROSERVICE_RETRY_ATTEMPTS=1

# Disable unnecessary features
MICROSERVICE_LOG_REQUESTS=false
MICROSERVICE_COLLECT_RESPONSE_TIMES=false

# Use in-memory caching
MICROSERVICE_CACHE_DRIVER=redis
MICROSERVICE_CACHE_TTL=60
```

## Security Configuration

### Enable Security Features

```env
# Require HTTPS
MICROSERVICE_REQUIRE_HTTPS=true

# Enable SSL verification
MICROSERVICE_VERIFY_SSL=true

# Configure authentication
MICROSERVICE_AUTH_TYPE=jwt
MICROSERVICE_JWT_SECRET=your_secure_jwt_secret

# Enable rate limiting
MICROSERVICE_RATE_LIMITING_ENABLED=true
MICROSERVICE_RATE_LIMIT=30

# Enable encryption
MICROSERVICE_ENCRYPTION_ENABLED=true
MICROSERVICE_ENCRYPTION_KEY=your_encryption_key
```

### Security Best Practices

1. **Use Environment-Specific Secrets**
   ```env
   # Generate secure random keys
   php artisan key:generate --show
   ```

2. **Rotate API Keys Regularly**
   ```bash
   # Rotate service API keys
   php artisan microservice:rotate-keys
   ```

3. **Monitor Security Events**
   ```env
   MICROSERVICE_LOG_LEVEL=info
   MICROSERVICE_LOG_SANITIZE=true
   ```

## Migration Guide

### From Monolithic to Microservices

1. **Phase 1: Enable Fallback Mode**
   ```env
   MICROSERVICE_ENABLE_FALLBACK=true
   MICROSERVICE_LOCAL_FALLBACK=true
   ```

2. **Phase 2: Deploy Services**
   ```env
   MICROSERVICE_MOCK_SERVICES=false
   DOCUMENT_SERVICE_URL=http://service-cluster:8001
   ```

3. **Phase 3: Full Microservice Mode**
   ```env
   MICROSERVICE_ENABLE_FALLBACK=false
   MICROSERVICE_LOCAL_FALLBACK=false
   ```

### Rollback Configuration

```bash
# Quick rollback to local mode
php artisan microservice:rollback --mode=local

# Complete configuration reset
php artisan microservice:config:reset
```

This configuration guide provides comprehensive setup instructions for the microservice architecture. Adjust the settings based on your specific requirements and environment.
