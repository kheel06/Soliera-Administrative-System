<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LegalService extends AbstractMicroservice
{
    protected string $serviceName = 'legal';

    /**
     * Create legal case
     */
    public function createCase(array $caseData): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($caseData) {
                $response = $this->post('/legal/cases', $caseData);
                $this->logCommunication('create_legal_case', $caseData, $response);
                return $response;
            },
            "legal_case_create_" . md5(json_encode($caseData))
        );
    }

    /**
     * Get legal case by ID
     */
    public function getCase(int $caseId): ?array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($caseId) {
                $response = $this->get("/legal/cases/{$caseId}");
                $this->logCommunication('get_legal_case', ['id' => $caseId], $response);
                return $response;
            },
            "legal_case_{$caseId}",
            1800 // Cache for 30 minutes
        );
    }

    /**
     * Update legal case
     */
    public function updateCase(int $caseId, array $updateData): array
    {
        $response = $this->put("/legal/cases/{$caseId}", $updateData);
        $this->logCommunication('update_legal_case', ['id' => $caseId, 'data' => $updateData], $response);
        
        // Clear cache
        Cache::forget("legal_case_{$caseId}");
        
        return $response;
    }

    /**
     * Search legal cases
     */
    public function searchCases(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $params = array_merge($filters, ['page' => $page, 'limit' => $limit]);
        
        return $this->executeWithCircuitBreaker(
            function () use ($params) {
                $response = $this->get('/legal/cases/search', $params);
                $this->logCommunication('search_legal_cases', $params, $response);
                return $response;
            },
            "legal_case_search_" . md5(json_encode($params)),
            300 // Cache for 5 minutes
        );
    }

    /**
     * Add evidence to case
     */
    public function addEvidence(int $caseId, array $evidenceData): array
    {
        return $this->post("/legal/cases/{$caseId}/evidence", $evidenceData);
    }

    /**
     * Get case evidence
     */
    public function getCaseEvidence(int $caseId): array
    {
        return $this->get("/legal/cases/{$caseId}/evidence");
    }

    /**
     * Add witness to case
     */
    public function addWitness(int $caseId, array $witnessData): array
    {
        return $this->post("/legal/cases/{$caseId}/witnesses", $witnessData);
    }

    /**
     * Get case witnesses
     */
    public function getCaseWitnesses(int $caseId): array
    {
        return $this->get("/legal/cases/{$caseId}/witnesses");
    }

    /**
     * Analyze document for legal risk
     */
    public function analyzeLegalRisk(int $documentId, array $options = []): array
    {
        return $this->post("/legal/analyze-risk", [
            'document_id' => $documentId,
            'options' => $options
        ]);
    }

    /**
     * Generate legal document
     */
    public function generateLegalDocument(array $documentData): array
    {
        return $this->post('/legal/documents/generate', $documentData);
    }

    /**
     * Get legal documents
     */
    public function getLegalDocuments(array $filters = []): array
    {
        return $this->get('/legal/documents', $filters);
    }

    /**
     * Create legal document submission
     */
    public function createDocumentSubmission(array $submissionData): array
    {
        return $this->post('/legal/submissions', $submissionData);
    }

    /**
     * Get case activities
     */
    public function getCaseActivities(int $caseId): array
    {
        return $this->get("/legal/cases/{$caseId}/activities");
    }

    /**
     * Add case activity
     */
    public function addCaseActivity(int $caseId, array $activityData): array
    {
        return $this->post("/legal/cases/{$caseId}/activities", $activityData);
    }

    /**
     * Get legal statistics
     */
    public function getLegalStats(array $filters = []): array
    {
        return $this->get('/legal/stats', $filters);
    }

    /**
     * Get compliance report
     */
    public function getComplianceReport(array $filters = []): array
    {
        return $this->get('/legal/compliance-report', $filters);
    }

    /**
     * Review document for compliance
     */
    public function reviewDocumentCompliance(int $documentId): array
    {
        return $this->post("/legal/documents/{$documentId}/compliance-review");
    }

    /**
     * Get case timeline
     */
    public function getCaseTimeline(int $caseId): array
    {
        return $this->get("/legal/cases/{$caseId}/timeline");
    }

    /**
     * Assign lawyer to case
     */
    public function assignLawyer(int $caseId, int $lawyerId): array
    {
        return $this->post("/legal/cases/{$caseId}/assign-lawyer", [
            'lawyer_id' => $lawyerId
        ]);
    }

    /**
     * Close case
     */
    public function closeCase(int $caseId, array $closureData): array
    {
        return $this->post("/legal/cases/{$caseId}/close", $closureData);
    }

    /**
     * Archive case
     */
    public function archiveCase(int $caseId, array $archiveData = []): array
    {
        return $this->post("/legal/cases/{$caseId}/archive", $archiveData);
    }

    /**
     * Get case documents
     */
    public function getCaseDocuments(int $caseId): array
    {
        return $this->get("/legal/cases/{$caseId}/documents");
    }

    /**
     * Link document to case
     */
    public function linkDocumentToCase(int $caseId, int $documentId): array
    {
        return $this->post("/legal/cases/{$caseId}/link-document", [
            'document_id' => $documentId
        ]);
    }

    /**
     * Get legal audit logs
     */
    public function getAuditLogs(array $filters = []): array
    {
        return $this->get('/legal/audit-logs', $filters);
    }

    /**
     * Generate legal report
     */
    public function generateReport(array $reportData): array
    {
        return $this->post('/legal/reports/generate', $reportData);
    }
}
