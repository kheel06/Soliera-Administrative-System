<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Microservices\ServiceGateway;
use App\Services\Microservices\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExternalDocumentImportController extends Controller
{
    private ServiceGateway $gateway;
    private DocumentService $documentService;

    public function __construct(ServiceGateway $gateway, DocumentService $documentService)
    {
        $this->gateway = $gateway;
        $this->documentService = $documentService;
    }
    /**
     * Import document from external microservice
     * This endpoint simulates real department system integrations
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $startTime = microtime(true);

        try {
            // Validate incoming payload
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'category' => 'required|string|in:contract,policy,legal_case,compliance,financial,report,memo,agreement',
                'department' => 'required|string',
                'confidentiality_level' => 'required|string|in:public,internal,confidential,restricted',
                'status' => 'nullable|string|in:active,archived,expiring_soon,expired,disposed',
                'retention_period' => 'required|string',
                'source_system' => 'required|string|max:100',
                'external_reference_id' => 'required|string|max:255',
                'description' => 'nullable|string',
                'metadata' => 'nullable|array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Use microservice to import document with fallback
            return $this->gateway->executeWithFallback(
                'document',
                function ($documentService) use ($data, $startTime) {
                    // Prepare document data for microservice
                    $documentData = [
                        'title' => $data['title'],
                        'description' => $data['description'] ?? "Imported from {$data['source_system']} microservice",
                        'department' => $data['department'],
                        'category' => $data['category'],
                        'status' => $data['status'] ?? 'archived',
                        'source' => 'external_integration',
                        'uploaded_by' => auth()->id() ?? 1,
                        'confidentiality_level' => $data['confidentiality_level'],
                        'retention_period' => $data['retention_period'],
                        'external_reference_id' => $data['external_reference_id'],
                        'import_source' => $data['source_system'],
                        'metadata' => $data['metadata'] ?? null,
                        'import_metadata' => [
                            'source_system' => $data['source_system'],
                            'external_reference_id' => $data['external_reference_id'],
                            'import_method' => 'API Integration (Microservice)',
                            'import_timestamp' => now()->toISOString(),
                            'imported_by' => auth()->id() ?? 'system'
                        ]
                    ];

                    // Import document via microservice
                    $result = $documentService->importDocument($documentData);

                    $duration = microtime(true) - $startTime;

                    Log::info('Document imported via microservice', [
                        'document_id' => $result['document_id'] ?? null,
                        'source_system' => $data['source_system'],
                        'external_reference_id' => $data['external_reference_id'],
                        'duration_seconds' => round($duration, 3),
                        'microservice_used' => true
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Document imported successfully via microservice',
                        'document_id' => $result['document_id'] ?? null,
                        'external_reference_id' => $data['external_reference_id'],
                        'processing_time_ms' => round($duration * 1000, 2),
                        'is_duplicate' => $result['is_duplicate'] ?? false,
                        'microservice_used' => true
                    ], 201);
                },
                function () use ($data, $startTime) {
                    // Fallback implementation using local database
                    return $this->fallbackImport($data, $startTime);
                }
            );

        } catch (\Exception $e) {
            Log::error('Document import failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
                'error_code' => 'IMPORT_ERROR'
            ], 500);
        }
    }

    /**
     * Fallback import implementation using local database
     */
    private function fallbackImport(array $data, float $startTime): \Illuminate\Http\JsonResponse
    {
        Log::warning('Using fallback document import', [
            'source_system' => $data['source_system'],
            'external_reference_id' => $data['external_reference_id']
        ]);

        // Parse retention period to years
        $retentionYears = $this->parseRetentionPeriod($data['retention_period']);

        // Start database transaction
        DB::beginTransaction();

        try {
            // Create document using local model
            $document = \App\Models\Document::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? "Imported from {$data['source_system']} microservice",
                'department' => $data['department'],
                'category' => $data['category'],
                'status' => $data['status'] ?? 'archived',
                'source' => 'external_integration',
                'uploaded_by' => auth()->id() ?? 1,
                'file_path' => 'documents/external_import_' . uniqid() . '.pdf',
                'confidentiality_level' => $data['confidentiality_level'],
                'workflow_stage' => ($data['status'] ?? 'archived') === 'archived' ? 'archived' : 'active',
                'archived_at' => ($data['status'] ?? 'archived') === 'archived' ? now() : null,
                'retention_until' => now()->addYears($retentionYears),
                'external_reference_id' => $data['external_reference_id'],
                'import_source' => $data['source_system'],
                'metadata' => isset($data['metadata']) ? $data['metadata'] : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create lifecycle log entry
            $lifecycleLog = $document->lifecycle_log ?? [];
            $lifecycleLog[] = [
                'step' => 'imported',
                'timestamp' => now()->toISOString(),
                'user_id' => auth()->id() ?? 'system',
                'details' => [
                    'source_system' => $data['source_system'],
                    'external_reference_id' => $data['external_reference_id'],
                    'import_method' => 'API Integration (Fallback)'
                ],
                'ip_address' => request()->ip()
            ];
            $document->update(['lifecycle_log' => $lifecycleLog]);

            DB::commit();

            $duration = microtime(true) - $startTime;

            Log::info('Document import successful (fallback)', [
                'document_id' => $document->id,
                'source_system' => $data['source_system'],
                'external_reference_id' => $data['external_reference_id'],
                'duration_seconds' => round($duration, 3),
                'fallback_used' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document imported successfully (fallback mode)',
                'document_id' => $document->id,
                'external_reference_id' => $data['external_reference_id'],
                'processing_time_ms' => round($duration * 1000, 2),
                'is_duplicate' => false,
                'fallback_used' => true
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Parse retention period string to years
     */
    private function parseRetentionPeriod(string $period): int
    {
        if (preg_match('/(\d+)\s*Year/i', $period, $matches)) {
            return (int) $matches[1];
        } elseif (stripos($period, 'Permanent') !== false) {
            return 100; // 100 years for permanent
        }
        return 7; // default
    }


    /**
     * Get import statistics
     */
    public function stats(Request $request)
    {
        try {
            return $this->gateway->executeWithFallback(
                'document',
                function ($documentService) {
                    // Get analytics from microservice
                    $analytics = $documentService->getDocumentAnalytics([
                        'type' => 'import_statistics',
                        'period' => 'last_30_days'
                    ]);

                    return response()->json([
                        'success' => true,
                        'stats' => $analytics,
                        'microservice_used' => true
                    ]);
                },
                function () {
                    // Fallback to local database
                    $stats = [
                        'total_imports' => \App\Models\DocumentImportLog::count(),
                        'successful_imports' => \App\Models\DocumentImportLog::where('import_status', 'success')->count(),
                        'failed_imports' => \App\Models\DocumentImportLog::where('import_status', 'failed')->count(),
                        'processing_imports' => \App\Models\DocumentImportLog::where('import_status', 'processing')->count(),
                        'imports_today' => \App\Models\DocumentImportLog::whereDate('created_at', today())->count(),
                        'imports_this_week' => \App\Models\DocumentImportLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                        'by_source_system' => \App\Models\DocumentImportLog::select('source_system', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                            ->groupBy('source_system')
                            ->get(),
                        'recent_imports' => \App\Models\DocumentImportLog::with('document:id,title,department,category')
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get()
                    ];

                    return response()->json([
                        'success' => true,
                        'stats' => $stats,
                        'fallback_used' => true
                    ]);
                }
            );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch stats: ' . $e->getMessage()
            ], 500);
        }
    }
}
