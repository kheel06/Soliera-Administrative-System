# Microservice Architecture Implementation

This document outlines the microservice architecture pattern implemented in the Hotel & Restaurant Administrative Management System.

## Table of Contents

1. [Overview](#overview)
2. [Architecture Components](#architecture-components)
3. [Configuration](#configuration)
4. [API Endpoints](#api-endpoints)
5. [Usage Examples](#usage-examples)
6. [Fallback Mechanism](#fallback-mechanism)
7. [Monitoring and Management](#monitoring-and-management)
8. [Deployment Considerations](#deployment-considerations)
9. [Development](#development)
10. [Migration Strategy](#migration-strategy)
11. [Benefits](#benefits)
12. [Challenges and Considerations](#challenges-and-considerations)
13. [Future Enhancements](#future-enhancements)
14. [Support](#support)

## Overview

The system has been transformed from a monolithic Laravel application to a microservice-based architecture while maintaining backward compatibility and providing fallback mechanisms.

### Key Features

- **Service Layer Abstraction**: Clean separation between business logic and infrastructure
- **Circuit Breaker Pattern**: Prevents cascade failures
- **Automatic Fallback**: Graceful degradation when services are unavailable
- **Health Monitoring**: Continuous service health checks
- **Load Balancing**: Support for multiple service instances
- **Comprehensive Logging**: Full observability of service communications

## Architecture Components

### 1. Service Layer Abstraction

#### AbstractMicroservice
- **Location**: `app/Services/Microservices/AbstractMicroservice.php`
- **Purpose**: Base class for all microservice clients
- **Features**:
  - HTTP client with retry logic
  - Circuit breaker pattern
  - Response caching
  - Health checking
  - Request/response logging

#### Service Implementations
- **DocumentService**: Handles document management operations
- **VisitorService**: Manages visitor registration and tracking
- **FacilityService**: Facility and reservation management
- **LegalService**: Legal case and document management
- **NotificationService**: Notification and alerting system

### 2. Service Gateway

#### ServiceGateway
- **Location**: `app/Services/Microservices/ServiceGateway.php`
- **Purpose**: Central point for service communication with fallback handling
- **Features**:
  - Service health monitoring
  - Automatic fallback to local implementations
  - Circuit breaker management
  - Parallel service execution
  - Batch operations

### 3. Service Registry

#### ServiceRegistry
- **Location**: `app/Services/Microservices/ServiceRegistry.php`
- **Purpose**: Service discovery and configuration management
- **Features**:
  - Dynamic service registration
  - Health check coordination
  - Configuration management
  - Service metrics collection

## Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Document Service
DOCUMENT_SERVICE_URL=http://localhost:8001
DOCUMENT_SERVICE_API_KEY=your_document_service_key
DOCUMENT_SERVICE_TIMEOUT=30
DOCUMENT_SERVICE_RETRY_ATTEMPTS=3
DOCUMENT_SERVICE_HEALTH_CHECK=60
DOCUMENT_SERVICE_CIRCUIT_THRESHOLD=5
DOCUMENT_SERVICE_CIRCUIT_TIMEOUT=300

# Visitor Service
VISITOR_SERVICE_URL=http://localhost:8002
VISITOR_SERVICE_API_KEY=your_visitor_service_key
VISITOR_SERVICE_TIMEOUT=30
VISITOR_SERVICE_RETRY_ATTEMPTS=3
VISITOR_SERVICE_HEALTH_CHECK=60
VISITOR_SERVICE_CIRCUIT_THRESHOLD=5
VISITOR_SERVICE_CIRCUIT_TIMEOUT=300

# Facility Service
FACILITY_SERVICE_URL=http://localhost:8003
FACILITY_SERVICE_API_KEY=your_facility_service_key
FACILITY_SERVICE_TIMEOUT=30
FACILITY_SERVICE_RETRY_ATTEMPTS=3
FACILITY_SERVICE_HEALTH_CHECK=60
FACILITY_SERVICE_CIRCUIT_THRESHOLD=5
FACILITY_SERVICE_CIRCUIT_TIMEOUT=300

# Legal Service
LEGAL_SERVICE_URL=http://localhost:8004
LEGAL_SERVICE_API_KEY=your_legal_service_key
LEGAL_SERVICE_TIMEOUT=30
LEGAL_SERVICE_RETRY_ATTEMPTS=3
LEGAL_SERVICE_HEALTH_CHECK=60
LEGAL_SERVICE_CIRCUIT_THRESHOLD=5
LEGAL_SERVICE_CIRCUIT_TIMEOUT=300

# Notification Service
NOTIFICATION_SERVICE_URL=http://localhost:8005
NOTIFICATION_SERVICE_API_KEY=your_notification_service_key
NOTIFICATION_SERVICE_TIMEOUT=30
NOTIFICATION_SERVICE_RETRY_ATTEMPTS=3
NOTIFICATION_SERVICE_HEALTH_CHECK=60
NOTIFICATION_SERVICE_CIRCUIT_THRESHOLD=5
NOTIFICATION_SERVICE_CIRCUIT_TIMEOUT=300

# Auth Service
AUTH_SERVICE_URL=http://localhost:8006
AUTH_SERVICE_API_KEY=your_auth_service_key
AUTH_SERVICE_TIMEOUT=30

# AI Service
AI_SERVICE_URL=http://localhost:8007
AI_SERVICE_API_KEY=your_ai_service_key
AI_SERVICE_TIMEOUT=60

# Global Settings
MICROSERVICE_ENABLE_FALLBACK=true
MICROSERVICE_LOG_REQUESTS=true
MICROSERVICE_CACHE_RESPONSES=true
MICROSERVICE_CACHE_TTL=300
MICROSERVICE_DEFAULT_TIMEOUT=30
MICROSERVICE_DEFAULT_RETRY_ATTEMPTS=3
MICROSERVICE_HEALTH_CHECK_INTERVAL=60
MICROSERVICE_CIRCUIT_BREAKER_THRESHOLD=5
MICROSERVICE_CIRCUIT_BREAKER_TIMEOUT=300

# Development Settings
MICROSERVICE_MOCK_SERVICES=false
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=false
MICROSERVICE_SIMULATE_FAILURES=false
MICROSERVICE_FAILURE_RATE=0

# Service Discovery
MICROSERVICE_DISCOVERY_ENABLED=false
MICROSERVICE_DISCOVERY_TYPE=consul
MICROSERVICE_DISCOVERY_HOST=localhost
MICROSERVICE_DISCOVERY_PORT=8500

# Load Balancing
MICROSERVICE_LOAD_BALANCING_ENABLED=false
MICROSERVICE_LOAD_BALANCING_STRATEGY=round_robin

# Monitoring
MICROSERVICE_MONITORING_ENABLED=true
MICROSERVICE_METRICS_ENDPOINT=/metrics
MICROSERVICE_COLLECT_RESPONSE_TIMES=true
MICROSERVICE_COLLECT_ERROR_RATES=true
MICROSERVICE_COLLECT_CIRCUIT_BREAKER_EVENTS=true

# Security
MICROSERVICE_REQUIRE_HTTPS=false
MICROSERVICE_VERIFY_SSL=true
MICROSERVICE_SHARED_SECRET=your_shared_secret
MICROSERVICE_JWT_SECRET=your_jwt_secret
MICROSERVICE_RATE_LIMITING_ENABLED=true
MICROSERVICE_RATE_LIMIT=60
```

### Configuration File

The main configuration is in `config/microservices.php` with comprehensive settings for:
- Service URLs and authentication
- Timeouts and retry policies
- Circuit breaker thresholds
- Health check intervals
- Monitoring and security settings

## API Endpoints

### Microservice Management

#### Health Check
```http
GET /api/microservices/health
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "services": {
    "document": {
      "url": "http://localhost:8001",
      "healthy": true,
      "circuit_breaker_open": false,
      "recent_failures": 0,
      "recent_successes": 15
    }
  },
  "summary": {
    "total": 5,
    "healthy": 5,
    "unhealthy": 0,
    "circuit_breakers_open": 0
  }
}
```

#### Service Registry
```http
GET /api/microservices/registry
Authorization: Bearer {token}
```

#### Execute Service Operation
```http
POST /api/microservices/execute
Authorization: Bearer {token}
Content-Type: application/json

{
  "service": "document",
  "operation": "create_document",
  "parameters": {
    "title": "Test Document",
    "category": "policy"
  }
}
```

### External Document Import

#### Import Document
```http
POST /api/external/documents/import
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Contract Document",
  "category": "contract",
  "department": "Legal",
  "confidentiality_level": "confidential",
  "retention_period": "7 Years",
  "source_system": "external_crm",
  "external_reference_id": "CRM-12345",
  "description": "Contract with vendor"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Document imported successfully via microservice",
  "document_id": 12345,
  "external_reference_id": "CRM-12345",
  "processing_time_ms": 245.67,
  "is_duplicate": false,
  "microservice_used": true
}
```

#### Get Statistics
```http
GET /api/external/documents/stats
Authorization: Bearer {token}
```

## Usage Examples

### Basic Service Call

```php
use App\Services\Microservices\ServiceGateway;

$gateway = app(ServiceGateway::class);

$result = $gateway->executeWithFallback(
    'document',
    function ($documentService) use ($documentData) {
        return $documentService->createDocument($documentData);
    },
    function () use ($documentData) {
        // Fallback implementation
        return Document::create($documentData);
    }
);
```

### Parallel Service Execution

```php
$results = $gateway->executeParallel([
    'document' => [
        'service' => 'document',
        'callback' => function ($service) use ($docData) {
            return $service->createDocument($docData);
        },
        'fallback' => function () {
            return ['fallback' => true];
        }
    ],
    'notification' => [
        'service' => 'notification',
        'callback' => function ($service) use ($notifData) {
            return $service->sendNotification($notifData);
        }
    ]
]);
```

### Direct Service Usage

```php
use App\Services\Microservices\DocumentService;

$documentService = app(DocumentService::class);
$document = $documentService->getDocument($documentId);

// Create document
$result = $documentService->createDocument([
    'title' => 'New Document',
    'category' => 'policy',
    'department' => 'HR'
]);

// Search documents
$searchResults = $documentService->searchDocuments([
    'category' => 'contract',
    'department' => 'Legal'
], 1, 20);
```

### Service Health Monitoring

```php
use App\Services\Microservices\ServiceRegistry;

// Check if service is healthy
$isHealthy = ServiceRegistry::isServiceHealthy('document');

// Get all healthy services
$healthyServices = ServiceRegistry::getHealthyServices();

// Get service metrics
$metrics = ServiceRegistry::getServiceMetrics();
```

## Fallback Mechanism

The system provides automatic fallback to local implementations when microservices are unavailable:

### How It Works

1. **Health Check**: Services are monitored for availability
2. **Circuit Breaker**: Automatically opens after consecutive failures
3. **Fallback Services**: Local implementations provide basic functionality
4. **Graceful Degradation**: System continues operating with limited features

### Fallback Service Examples

```php
// Fallback document service
class FallbackDocumentService extends AbstractMicroservice
{
    public function createDocument(array $documentData): array
    {
        // Local database implementation
        $document = Document::create($documentData);
        return [
            'success' => true,
            'document_id' => $document->id,
            'fallback_used' => true
        ];
    }
}
```

## Monitoring and Management

### Console Commands

#### Health Check
```bash
# Check all services
php artisan microservice:health-check

# Check specific service
php artisan microservice:health-check --service=document
```

#### Service Status
```bash
# Basic status
php artisan microservice:status

# Detailed metrics
php artisan microservice:status --detailed
```

#### Restart Service
```bash
# Restart with confirmation
php artisan microservice:restart document

# Force restart without confirmation
php artisan microservice:restart document --force
```

### Logging

All microservice communications are logged with:
- Request/response details
- Service health status
- Circuit breaker events
- Fallback activations

**Example Log Entry:**
```
[2024-01-24 02:14:23] production.INFO: Microservice communication 
{
  "service": "document",
  "action": "create_document",
  "request_data": {"title": "Test Document"},
  "response_data": {"document_id": 12345},
  "timestamp": "2024-01-24T02:14:23.123456Z"
}
```

### Metrics

The system collects metrics for:
- Response times
- Error rates
- Service availability
- Circuit breaker status

**Access Metrics:**
```http
GET /api/microservices/metrics
```

## Deployment Considerations

### Service Dependencies

1. **Service Discovery**: Services register themselves on startup
2. **Health Monitoring**: Continuous health checks
3. **Load Balancing**: Multiple instances can be configured
4. **Circuit Breakers**: Prevent cascade failures

### Scaling

#### Horizontal Scaling
```php
// config/microservices.php
'load_balancing' => [
    'enabled' => true,
    'strategy' => 'round_robin',
    'instances' => [
        'document' => [
            ['url' => 'http://localhost:8001', 'weight' => 1],
            ['url' => 'http://localhost:8008', 'weight' => 1],
        ],
    ],
],
```

#### Auto-scaling Configuration
```bash
# Environment-based scaling
MICROSERVICE_AUTO_SCALE_ENABLED=true
MICROSERVICE_MIN_INSTANCES=2
MICROSERVICE_MAX_INSTANCES=10
MICROSERVICE_SCALE_UP_THRESHOLD=80
MICROSERVICE_SCALE_DOWN_THRESHOLD=20
```

### Security

#### Authentication
```php
// Bearer Token Authentication
'api_key' => env('DOCUMENT_SERVICE_API_KEY'),

// JWT Authentication
'jwt_secret' => env('MICROSERVICE_JWT_SECRET'),

// Shared Secret
'shared_secret' => env('MICROSERVICE_SHARED_SECRET'),
```

#### Rate Limiting
```php
'rate_limiting' => [
    'enabled' => true,
    'requests_per_minute' => 60,
],
```

## Development

### Adding New Services

1. **Create Service Class**
```php
<?php
// app/Services/Microservices/NewService.php
class NewService extends AbstractMicroservice
{
    protected string $serviceName = 'new_service';
    
    public function performOperation(array $data): array
    {
        return $this->post('/operations', $data);
    }
}
```

2. **Register in Service Gateway**
```php
// app/Services/Microservices/ServiceGateway.php
private function initializeServices(): void
{
    $this->services['new_service'] = new NewService();
}
```

3. **Add Configuration**
```php
// config/microservices.php
'new_service' => [
    'url' => env('NEW_SERVICE_URL', 'http://localhost:8008'),
    'api_key' => env('NEW_SERVICE_API_KEY'),
    'timeout' => 30,
],
```

4. **Create Fallback Service**
```php
class FallbackNewService extends AbstractMicroservice
{
    public function performOperation(array $data): array
    {
        // Local implementation
        return ['success' => true, 'fallback_used' => true];
    }
}
```

### Testing

#### Unit Tests
```php
class DocumentServiceTest extends TestCase
{
    public function testCreateDocument()
    {
        $service = new DocumentService();
        $result = $service->createDocument($documentData);
        
        $this->assertArrayHasKey('success', $result);
        $this->assertTrue($result['success']);
    }
}
```

#### Integration Tests
```php
class MicroserviceIntegrationTest extends TestCase
{
    public function testServiceCommunication()
    {
        $gateway = app(ServiceGateway::class);
        
        $result = $gateway->executeWithFallback(
            'document',
            fn($service) => $service->createDocument($data)
        );
        
        $this->assertNotNull($result);
    }
}
```

#### Mock Services
```php
// Enable mock mode for testing
MICROSERVICE_MOCK_SERVICES=true
MICROSERVICE_SIMULATE_FAILURES=true
MICROSERVICE_FAILURE_RATE=50
```

### Local Development

Enable development mode in `.env`:
```env
MICROSERVICE_MOCK_SERVICES=true
MICROSERVICE_LOCAL_FALLBACK=true
MICROSERVICE_DEBUG_MODE=true
APP_DEBUG=true
```

## Migration Strategy

### Phase 1: Service Layer ✅
- ✅ Abstract service layer implemented
- ✅ Service gateway with fallback
- ✅ Configuration management
- ✅ Health monitoring

### Phase 2: Service Extraction 🔄
- 🔄 Extract document management
- 🔄 Extract visitor management
- 🔄 Extract facility management
- 🔄 Extract legal management
- 🔄 Extract notification system

### Phase 3: Full Microservice Deployment ⏳
- ⏳ Deploy individual services
- ⏳ Implement service discovery
- ⏳ Set up monitoring and logging
- ⏳ Optimize performance

### Migration Steps

1. **Preparation**
   ```bash
   # Backup current system
   php artisan backup:run
   
   # Enable fallback mode
   MICROSERVICE_ENABLE_FALLBACK=true
   ```

2. **Service Extraction**
   ```bash
   # Extract document service
   php artisan microservice:extract document
   
   # Test extracted service
   php artisan microservice:test document
   ```

3. **Deployment**
   ```bash
   # Deploy to production
   php artisan microservice:deploy --env=production
   
   # Monitor health
   php artisan microservice:health-check
   ```

## Benefits

### 1. **Scalability**
- Individual services can be scaled independently
- Resource allocation based on service-specific needs
- Horizontal scaling with load balancing

### 2. **Resilience**
- Fallback mechanisms ensure system availability
- Circuit breakers prevent cascade failures
- Graceful degradation under load

### 3. **Maintainability**
- Smaller, focused codebases
- Clear separation of concerns
- Independent deployment cycles

### 4. **Technology Diversity**
- Different services can use different technologies
- Framework and language flexibility
- Best tool for each specific problem

### 5. **Team Autonomy**
- Teams can work on services independently
- Faster development cycles
- Clear ownership and responsibility

## Challenges and Considerations

### 1. **Complexity**
- Increased system complexity
- More moving parts to manage
- Higher operational overhead

### 2. **Network Latency**
- Service communication overhead
- Performance impact of distributed calls
- Need for efficient serialization

### 3. **Data Consistency**
- Managing distributed transactions
- Eventual consistency patterns
- Data synchronization challenges

### 4. **Monitoring**
- Need for comprehensive observability
- Distributed tracing requirements
- Complex debugging scenarios

### 5. **Testing**
- More complex testing scenarios
- Integration test complexity
- Mock service management

## Future Enhancements

### 1. **Event-Driven Architecture**
```php
// Message queue integration
'events' => [
    'enabled' => true,
    'driver' => 'redis',
    'queue_name' => 'microservice_events',
],
```

### 2. **Distributed Tracing**
```php
// OpenTelemetry integration
'tracing' => [
    'enabled' => true,
    'service_name' => 'admin-system',
    'endpoint' => 'http://jaeger:14268/api/traces',
],
```

### 3. **Service Mesh**
```php
// Istio/Linkerd integration
'service_mesh' => [
    'enabled' => true,
    'provider' => 'istio',
    'sidecar_injection' => true,
],
```

### 4. **Auto-scaling**
```php
// Kubernetes integration
'autoscaling' => [
    'enabled' => true,
    'min_replicas' => 2,
    'max_replicas' => 10,
    'cpu_threshold' => 80,
    'memory_threshold' => 80,
],
```

### 5. **Multi-Region Deployment**
```php
// Geographic distribution
'deployment' => [
    'regions' => ['us-east-1', 'eu-west-1', 'ap-southeast-1'],
    'failover' => true,
    'latency_routing' => true,
],
```

## Support

### Getting Help

1. **Check Logs**
   ```bash
   # Application logs
   tail -f storage/logs/laravel.log
   
   # Microservice logs
   tail -f storage/logs/microservices.log
   ```

2. **Health Diagnostics**
   ```bash
   # Check all services
   php artisan microservice:health-check --verbose
   
   # Detailed status
   php artisan microservice:status --detailed
   ```

3. **Service Registry**
   ```bash
   # List registered services
   php artisan microservice:registry
   
   # Check specific service
   php artisan microservice:registry --service=document
   ```

### Common Issues

#### Service Not Responding
```bash
# Check service health
curl http://localhost:8001/health

# Check circuit breaker status
php artisan microservice:status --detailed

# Reset circuit breaker
php artisan microservice:restart document --force
```

#### Fallback Mode Active
```bash
# Check why fallback is active
php artisan microservice:health-check --verbose

# Test service connectivity
php artisan microservice:test document

# Check configuration
php artisan config:show microservices
```

#### Performance Issues
```bash
# Check response times
php artisan microservice:metrics

# Monitor resource usage
php artisan microservice:monitor --resource-usage

# Analyze slow queries
php artisan microservice:analyze --slow-queries
```

### Documentation Resources

- **API Documentation**: `/docs/api/microservices`
- **Configuration Guide**: `/docs/configuration/microservices`
- **Deployment Guide**: `/docs/deployment/microservices`
- **Troubleshooting**: `/docs/troubleshooting/microservices`

### Community Support

- **GitHub Issues**: Report bugs and request features
- **Discord Channel**: Real-time community support
- **Stack Overflow**: Technical questions and answers
- **Blog Posts**: Best practices and tutorials

---

## Conclusion

This microservice architecture provides a solid foundation for scaling the Hotel & Restaurant Administrative Management System while maintaining reliability, performance, and backward compatibility. The implementation follows industry best practices and provides a clear migration path for future enhancements.

The system is designed to be:
- **Resilient** with automatic fallback mechanisms
- **Scalable** with independent service scaling
- **Observable** with comprehensive monitoring
- **Maintainable** with clear separation of concerns
- **Future-proof** with extensible architecture

For questions or support, refer to the troubleshooting section or contact the development team.
