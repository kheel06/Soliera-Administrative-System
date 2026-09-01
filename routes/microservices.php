<?php

use App\Http\Controllers\Api\MicroserviceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Microservice API Routes
|--------------------------------------------------------------------------
|
| Routes for monitoring and managing microservices
|
*/

Route::prefix('microservices')->name('microservices.')->group(function () {
    
    // Health check for all services
    Route::get('/health', [MicroserviceController::class, 'health'])->name('health');
    
    // Get detailed metrics for specific service
    Route::get('/metrics/{serviceName}', [MicroserviceController::class, 'serviceMetrics'])
        ->name('service.metrics')
        ->where('serviceName', '[a-zA-Z0-9_-]+');
    
    // Test service connectivity
    Route::post('/test/{serviceName}', [MicroserviceController::class, 'testService'])
        ->name('service.test')
        ->where('serviceName', '[a-zA-Z0-9_-]+');
    
    // Reset circuit breaker for service
    Route::post('/reset-circuit-breaker/{serviceName}', [MicroserviceController::class, 'resetCircuitBreaker'])
        ->name('service.reset_circuit_breaker')
        ->where('serviceName', '[a-zA-Z0-9_-]+');
    
    // Execute service operation
    Route::post('/execute', [MicroserviceController::class, 'executeOperation'])
        ->name('service.execute');
    
    // Get service registry information
    Route::get('/registry', [MicroserviceController::class, 'registry'])
        ->name('registry');
    
    // Service-specific health endpoints
    Route::prefix('services')->group(function () {
        Route::get('/document/health', function () {
            return response()->json([
                'service' => 'document',
                'status' => 'healthy',
                'timestamp' => now()->toISOString()
            ]);
        })->name('services.document.health');
        
        Route::get('/visitor/health', function () {
            return response()->json([
                'service' => 'visitor',
                'status' => 'healthy',
                'timestamp' => now()->toISOString()
            ]);
        })->name('services.visitor.health');
        
        Route::get('/facility/health', function () {
            return response()->json([
                'service' => 'facility',
                'status' => 'healthy',
                'timestamp' => now()->toISOString()
            ]);
        })->name('services.facility.health');
        
        Route::get('/legal/health', function () {
            return response()->json([
                'service' => 'legal',
                'status' => 'healthy',
                'timestamp' => now()->toISOString()
            ]);
        })->name('services.legal.health');
        
        Route::get('/notification/health', function () {
            return response()->json([
                'service' => 'notification',
                'status' => 'healthy',
                'timestamp' => now()->toISOString()
            ]);
        })->name('services.notification.health');
    });
    
    // Admin routes (require authentication)
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/admin/status', function () {
            return response()->json([
                'message' => 'Admin microservice status',
                'timestamp' => now()->toISOString(),
                'services' => app(\App\Services\Microservices\ServiceGateway::class)->getHealthStatus()
            ]);
        })->name('admin.status');
        
        Route::post('/admin/restart/{serviceName}', function ($serviceName) {
            // This would trigger a service restart
            return response()->json([
                'message' => "Service {$serviceName} restart initiated",
                'timestamp' => now()->toISOString()
            ]);
        })->name('admin.restart');
    });
});
