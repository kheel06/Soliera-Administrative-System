<?php

namespace App\Services\Microservices;

use App\Models\Document;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DocumentService extends AbstractMicroservice
{
    protected string $serviceName = 'document';

    /**
     * Create document via microservice
     */
    public function createDocument(array $documentData): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($documentData) {
                $response = $this->post('/documents', $documentData);
                $this->logCommunication('create_document', $documentData, $response);
                return $response;
            },
            "document_create_" . md5(json_encode($documentData))
        );
    }

    /**
     * Get document by ID
     */
    public function getDocument(int $documentId): ?array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($documentId) {
                $response = $this->get("/documents/{$documentId}");
                $this->logCommunication('get_document', ['id' => $documentId], $response);
                return $response;
            },
            "document_{$documentId}",
            3600 // Cache for 1 hour
        );
    }

    /**
     * Update document
     */
    public function updateDocument(int $documentId, array $data): array
    {
        $response = $this->put("/documents/{$documentId}", $data);
        $this->logCommunication('update_document', ['id' => $documentId, 'data' => $data], $response);
        
        // Clear cache
        Cache::forget("document_{$documentId}");
        
        return $response;
    }

    /**
     * Delete document
     */
    public function deleteDocument(int $documentId): bool
    {
        $response = $this->delete("/documents/{$documentId}");
        $this->logCommunication('delete_document', ['id' => $documentId], $response);
        
        // Clear cache
        Cache::forget("document_{$documentId}");
        
        return $response['success'] ?? false;
    }

    /**
     * Search documents
     */
    public function searchDocuments(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $params = array_merge($filters, ['page' => $page, 'limit' => $limit]);
        
        return $this->executeWithCircuitBreaker(
            function () use ($params) {
                $response = $this->get('/documents/search', $params);
                $this->logCommunication('search_documents', $params, $response);
                return $response;
            },
            "document_search_" . md5(json_encode($params)),
            300 // Cache for 5 minutes
        );
    }

    /**
     * Process document with AI
     */
    public function processDocumentWithAI(int $documentId, array $options = []): array
    {
        return $this->post("/documents/{$documentId}/process", [
            'ai_analysis' => true,
            'extract_text' => true,
            'classify' => true,
            'options' => $options
        ]);
    }

    /**
     * Get document analytics
     */
    public function getDocumentAnalytics(array $filters = []): array
    {
        return $this->get('/documents/analytics', $filters);
    }

    /**
     * Import document from external system
     */
    public function importDocument(array $importData): array
    {
        $response = $this->post('/documents/import', $importData);
        $this->logCommunication('import_document', $importData, $response);
        return $response;
    }

    /**
     * Export documents
     */
    public function exportDocuments(array $documentIds, string $format = 'pdf'): array
    {
        return $this->post('/documents/export', [
            'document_ids' => $documentIds,
            'format' => $format
        ]);
    }

    /**
     * Get document lifecycle logs
     */
    public function getDocumentLifecycle(int $documentId): array
    {
        return $this->get("/documents/{$documentId}/lifecycle");
    }

    /**
     * Update document workflow stage
     */
    public function updateWorkflowStage(int $documentId, string $stage, array $metadata = []): array
    {
        return $this->put("/documents/{$documentId}/workflow", [
            'stage' => $stage,
            'metadata' => $metadata,
            'updated_by' => auth()->id()
        ]);
    }

    /**
     * Check document retention policy
     */
    public function checkRetentionPolicy(int $documentId): array
    {
        return $this->get("/documents/{$documentId}/retention-check");
    }

    /**
     * Archive document
     */
    public function archiveDocument(int $documentId, array $options = []): array
    {
        return $this->post("/documents/{$documentId}/archive", $options);
    }

    /**
     * Get documents by department
     */
    public function getDocumentsByDepartment(string $department, array $filters = []): array
    {
        return $this->get('/documents/by-department', array_merge($filters, ['department' => $department]));
    }

    /**
     * Bulk operations on documents
     */
    public function bulkUpdate(array $documentIds, array $updateData): array
    {
        return $this->post('/documents/bulk-update', [
            'document_ids' => $documentIds,
            'update_data' => $updateData
        ]);
    }
}
