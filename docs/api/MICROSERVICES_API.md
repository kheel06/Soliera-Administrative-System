# Microservices API Documentation

## Overview

This document provides comprehensive API documentation for the microservice architecture implemented in the Hotel & Restaurant Administrative Management System.

## Base URL

```
http://your-domain.com/api
```

## Authentication

All API endpoints require Bearer token authentication:

```http
Authorization: Bearer {your-api-token}
```

## API Endpoints

### Microservice Management

#### Health Check

Check the health status of all registered microservices.

```http
GET /api/microservices/health
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
      "recent_successes": 15,
      "last_check": "2024-01-24T02:14:23.123456Z"
    },
    "visitor": {
      "url": "http://localhost:8002",
      "healthy": false,
      "circuit_breaker_open": true,
      "recent_failures": 5,
      "recent_successes": 0,
      "last_check": "2024-01-24T02:14:23.123456Z"
    }
  },
  "summary": {
    "total": 5,
    "healthy": 4,
    "unhealthy": 1,
    "circuit_breakers_open": 1
  }
}
```

#### Service Registry

Get information about all registered services and their configurations.

```http
GET /api/microservices/registry
```

**Response:**
```json
{
  "success": true,
  "registered_services": {
    "document": {
      "url": "http://localhost:8001",
      "timeout": 30,
      "retry_attempts": 3,
      "health_check_interval": 60
    }
  },
  "healthy_services": {
    "document": {
      "url": "http://localhost:8001",
      "timeout": 30,
      "retry_attempts": 3
    }
  },
  "metrics": {
    "document": {
      "url": "http://localhost:8001",
      "healthy": true,
      "last_check": "2024-01-24T02:14:23.123456Z",
      "circuit_breaker_open": false
    }
  },
  "timestamp": "2024-01-24T02:14:23.123456Z"
}
```

#### Execute Service Operation

Execute operations on specific services with automatic fallback support.

```http
POST /api/microservices/execute
Content-Type: application/json
```

**Request Body:**
```json
{
  "service": "document",
  "operation": "create_document",
  "parameters": {
    "title": "Test Document",
    "category": "policy",
    "department": "HR",
    "description": "Test document description"
  }
}
```

**Response:**
```json
{
  "success": true,
  "result": {
    "success": true,
    "document_id": 12345,
    "message": "Document created successfully"
  },
  "service": "document",
  "operation": "create_document",
  "timestamp": "2024-01-24T02:14:23.123456Z"
}
```

#### Service-Specific Metrics

Get detailed metrics for a specific service.

```http
GET /api/microservices/services/{serviceName}/metrics
```

**Path Parameters:**
- `serviceName` - The name of the service (document, visitor, facility, legal, notification)

**Response:**
```json
{
  "success": true,
  "service": "document",
  "config": {
    "url": "http://localhost:8001",
    "timeout": 30,
    "retry_attempts": 3
  },
  "status": {
    "healthy": true,
    "circuit_breaker_open": false,
    "recent_failures": 0,
    "recent_successes": 15
  },
  "metrics": {
    "uptime_percentage": 99.5,
    "average_response_time": 150.5,
    "total_requests": 1250,
    "error_rate": 0.5
  }
}
```

#### Test Service Connectivity

Test connectivity to a specific service.

```http
POST /api/microservices/services/{serviceName}/test
```

**Response:**
```json
{
  "success": true,
  "service": "document",
  "healthy": true,
  "response_time_ms": 145.67,
  "timestamp": "2024-01-24T02:14:23.123456Z",
  "status": "operational"
}
```

#### Reset Circuit Breaker

Reset the circuit breaker for a specific service.

```http
POST /api/microservices/services/{serviceName}/reset-circuit-breaker
```

**Response:**
```json
{
  "success": true,
  "message": "Circuit breaker reset for service 'document'",
  "timestamp": "2024-01-24T02:14:23.123456Z"
}
```

### External Document Import

#### Import Document

Import documents from external systems using the microservice architecture.

```http
POST /api/external/documents/import
Content-Type: application/json
```

**Request Body:**
```json
{
  "title": "Contract Document",
  "category": "contract",
  "department": "Legal",
  "confidentiality_level": "confidential",
  "status": "active",
  "retention_period": "7 Years",
  "source_system": "external_crm",
  "external_reference_id": "CRM-12345",
  "description": "Contract with vendor XYZ",
  "metadata": {
    "vendor": "XYZ Corp",
    "contract_value": 50000,
    "start_date": "2024-01-01"
  }
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

#### Get Import Statistics

Get statistics about document imports from microservice or fallback to local database.

```http
GET /api/external/documents/stats
```

**Response:**
```json
{
  "success": true,
  "stats": {
    "total_imports": 1250,
    "successful_imports": 1200,
    "failed_imports": 45,
    "processing_imports": 5,
    "imports_today": 25,
    "imports_this_week": 150,
    "by_source_system": [
      {
        "source_system": "external_crm",
        "count": 800
      },
      {
        "source_system": "document_management",
        "count": 450
      }
    ],
    "recent_imports": [
      {
        "id": 12345,
        "source_system": "external_crm",
        "external_reference_id": "CRM-12345",
        "import_status": "success",
        "created_at": "2024-01-24T02:14:23.123456Z",
        "document": {
          "id": 12345,
          "title": "Contract Document",
          "department": "Legal",
          "category": "contract"
        }
      }
    ]
  },
  "microservice_used": true
}
```

## Error Responses

All endpoints return consistent error responses:

```json
{
  "success": false,
  "message": "Error description",
  "error_code": "ERROR_CODE",
  "errors": {
    "field": "Error details"
  }
}
```

### Common Error Codes

- `UNAUTHORIZED` - Invalid or missing authentication token
- `SERVICE_UNAVAILABLE` - Microservice is not available
- `VALIDATION_FAILED` - Request validation failed
- `RATE_LIMIT_EXCEEDED` - Too many requests
- `CIRCUIT_BREAKER_OPEN` - Service circuit breaker is open
- `TIMEOUT` - Service request timed out

### HTTP Status Codes

- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `429` - Rate Limit Exceeded
- `500` - Internal Server Error
- `503` - Service Unavailable

## Rate Limiting

API endpoints are rate-limited to prevent abuse:

- **Default Limit**: 60 requests per minute per authenticated user
- **Burst Limit**: 10 requests per second
- **Headers**: Rate limit information is included in response headers

```http
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1643030400
```

## Pagination

List endpoints support pagination:

```http
GET /api/external/documents/stats?page=2&limit=20
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `limit` - Items per page (default: 20, max: 100)

**Response:**
```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 2,
    "per_page": 20,
    "total": 100,
    "last_page": 5,
    "from": 21,
    "to": 40
  }
}
```

## Filtering and Sorting

Many endpoints support filtering and sorting:

```http
GET /api/microservices/health?service=document&status=healthy&sort=created_at&order=desc
```

**Common Query Parameters:**
- `service` - Filter by service name
- `status` - Filter by health status
- `sort` - Field to sort by
- `order` - Sort direction (asc, desc)
- `date_from` - Filter by date range (start)
- `date_to` - Filter by date range (end)

## Webhooks

The system supports webhooks for real-time notifications:

### Configure Webhook

```http
POST /api/microservices/webhooks
Content-Type: application/json
```

**Request Body:**
```json
{
  "url": "https://your-domain.com/webhook",
  "events": ["service.health_changed", "service.error"],
  "secret": "webhook_secret"
}
```

### Webhook Payload

```json
{
  "event": "service.health_changed",
  "service": "document",
  "data": {
    "previous_status": "unhealthy",
    "current_status": "healthy",
    "timestamp": "2024-01-24T02:14:23.123456Z"
  },
  "signature": "sha256=..."
}
```

## SDK Examples

### PHP

```php
use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'http://your-domain.com/api']);

// Health check
$response = $client->get('microservices/health', [
    'headers' => ['Authorization' => 'Bearer ' . $token]
]);

// Import document
$response = $client->post('external/documents/import', [
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json'
    ],
    'json' => $documentData
]);
```

### JavaScript

```javascript
const axios = require('axios');

const client = axios.create({
  baseURL: 'http://your-domain.com/api',
  headers: {
    'Authorization': `Bearer ${token}`
  }
});

// Health check
const health = await client.get('/microservices/health');

// Import document
const result = await client.post('/external/documents/import', documentData);
```

### Python

```python
import requests

headers = {'Authorization': f'Bearer {token}'}

# Health check
response = requests.get('http://your-domain.com/api/microservices/health', headers=headers)

# Import document
response = requests.post(
    'http://your-domain.com/api/external/documents/import',
    json=document_data,
    headers=headers
)
```

## Testing

### Test Environment

Use the test environment for development:

```bash
# Set test environment
APP_ENV=testing
MICROSERVICE_MOCK_SERVICES=true

# Run tests
php artisan test
```

### Mock Responses

Enable mock mode for testing:

```http
GET /api/microservices/health?mock=true
```

**Mock Response:**
```json
{
  "success": true,
  "mock": true,
  "services": {
    "document": {"healthy": true, "mock": true},
    "visitor": {"healthy": true, "mock": true}
  }
}
```

## Support

For API support:
- Check the [Troubleshooting Guide](../troubleshooting/MICROSERVICES.md)
- Review [Common Issues](#common-issues)
- Contact the development team

## Changelog

### v1.0.0 (2024-01-24)
- Initial microservice API implementation
- Health check endpoints
- Document import functionality
- Service management endpoints

### v1.1.0 (Planned)
- Enhanced monitoring endpoints
- Webhook support
- Advanced filtering options
- Performance metrics
