<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LegalAiResult;
use App\Services\GeminiService;
use App\Services\DocumentTextExtractorService;

class AiLegalController extends Controller
{
    protected $geminiService;
    protected $textExtractor;

    public function __construct(GeminiService $geminiService, DocumentTextExtractorService $textExtractor)
    {
        $this->geminiService = $geminiService;
        $this->textExtractor = $textExtractor;
    }
    public function index()
    {
        // Metrics
        $totalAnalyzed = LegalAiResult::count();
        $highRiskCount = LegalAiResult::whereIn('risk_level', ['high', 'critical'])->count();
        // Estimate 20 mins saved per document
        $timeSavedHours = round(($totalAnalyzed * 20) / 60, 1);

        // Recent Analyses
        $recentAnalyses = LegalAiResult::latest()->take(5)->get();

        return view('legal.ai.insights', compact('totalAnalyzed', 'highRiskCount', 'timeSavedHours', 'recentAnalyses'));
    }

    public function create()
    {
        return view('legal.ai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx,txt,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $originalFilename = $file->getClientOriginalName();

        // 1. Save file temporarily
        $tempPath = $file->storeAs('temp', uniqid() . '_' . $originalFilename);
        $fullPath = storage_path('app/' . $tempPath);

        try {
            // 2. Extract REAL text content with Quality Metrics
            $extraction = $this->textExtractor->extractText($fullPath);

            // FAIL LOUDLY POLICY: If extraction is unusable, tell the user.
            if (!$extraction['is_valid']) {
                if (file_exists($fullPath))
                    unlink($fullPath);
                return redirect()->back()->with('error', "DOCUMENT UNREADABLE: Extraction reliability is too low (" . ($extraction['quality']['reliability_score'] * 100) . "%). Please ensure you are uploading a searchable PDF or high-quality image.");
            }

            // 3. Perform REAL AI Analysis with Quality-Calibrated Confidence
            $aiAnalysis = $this->geminiService->analyzeDocumentEnhanced($extraction['text'], $extraction['quality']);

            if (isset($aiAnalysis['error']) && $aiAnalysis['error']) {
                if (file_exists($fullPath))
                    unlink($fullPath);
                return redirect()->back()->with('error', 'AI Analysis Failed: ' . ($aiAnalysis['message'] ?? 'Unknown error'));
            }

            // Clean up temp file
            if (file_exists($fullPath))
                unlink($fullPath);

            // 4. Map AI results to database model
            $riskLevel = strtolower($aiAnalysis['legal_risk_score'] ?? 'low');
            $complianceStatus = $aiAnalysis['compliance_status'] ?? 'review_required';
            $violationSeverity = $aiAnalysis['violation_score'] ?? 'Medium';

            // Convert string-based flagged issues to the structured array the view expects
            $rawIssues = $aiAnalysis['flagged_issues'] ?? [];
            $formattedViolations = [];

            foreach ($rawIssues as $issueStr) {
                if (empty(trim($issueStr)))
                    continue;

                $issue = $issueStr;
                $evidence = 'Not specified in extraction';

                // Parse "Issue | EVIDENCE: Quote" format if returned by AI
                if (strpos($issueStr, '| EVIDENCE:') !== false) {
                    $parts = explode('| EVIDENCE:', $issueStr);
                    $issue = trim($parts[0]);
                    $evidence = trim($parts[1], " \t\n\r\0\x0B\"");
                }

                $formattedViolations[] = [
                    'issue' => $issue,
                    'severity' => $violationSeverity,
                    'clause_text' => $evidence
                ];
            }

            $analysis = LegalAiResult::create([
                'document_id' => null,
                'analysis_type' => 'document_intelligence_v2',
                'ai_result' => array_merge($aiAnalysis, [
                    'extraction_method' => $extraction['method'],
                    'original_filename' => $originalFilename,
                    'is_low_confidence' => ($aiAnalysis['confidence'] ?? 0) < 0.5
                ]),
                'document_type' => $aiAnalysis['category'] ?? 'General Document',
                'confidence' => ($aiAnalysis['confidence'] ?? 0.5) * 100,
                'detected_violations' => $formattedViolations,
                'applicable_laws' => [$aiAnalysis['legal_implications'] ?? 'Philippine Law'],
                'compliance_status' => $complianceStatus,
                'risk_level' => $riskLevel,
                'summary' => $aiAnalysis['summary'] ?? 'Analysis complete.',
                'policy_links' => [],
                'recommendations' => $aiAnalysis['suggested_clauses'] ?? [],
                'ai_model' => 'Gemini-1.5-Flash-Pro',
                'processing_time' => 2.5,
                'metadata' => [
                    'extraction_stats' => $extraction['quality'],
                    'model_certainty' => $aiAnalysis['model_confidence_score'] ?? 0
                ]
            ]);

            // Notify stakeholders
            \App\Services\SystemNotificationService::notifyAiAnalysisAction('completed', $analysis);

            return redirect()->route('legal.ai.show', $analysis->id)->with('success', 'Document Intelligence Analysis complete.');

        } catch (\Exception $e) {
            if (file_exists($fullPath))
                unlink($fullPath);
            \Log::error('AI Legal Assistant Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Analysis Critical Error: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $result = LegalAiResult::findOrFail($id);
        return view('legal.ai.show', compact('result'));
    }
}
