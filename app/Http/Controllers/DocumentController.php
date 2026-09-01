<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentRequest;
use App\Models\FacilityReservation;
use App\Models\AccessLog;
use App\Models\DisposalHistory;
use App\Services\GeminiService;
use App\Services\DocumentTextExtractorService;
use App\Services\DocumentWorkflowNotificationService;
use App\Jobs\ProcessReservationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    protected $textExtractor;
    protected $geminiService;
    protected $notificationService;

    public function __construct(DocumentTextExtractorService $textExtractor, GeminiService $geminiService, DocumentWorkflowNotificationService $notificationService)
    {
        $this->textExtractor = $textExtractor;
        $this->geminiService = $geminiService;
        $this->notificationService = $notificationService;
    }

    public function bulkDestroy(Request $request)
    {
        // Permission check
        if (!in_array(Auth::user()->role, ['Admin Manager', 'Owner'])) {
            return redirect()->back()->with('error', 'You do not have permission to perform bulk deletions.');
        }

        $folderIds = $request->input('selected_folders', []);
        $documentIds = $request->input('selected_documents', []);
        $count = 0;

        // Delete Folders
        if (!empty($folderIds)) {
            $folders = \App\Models\Folder::whereIn('id', $folderIds)->get();
            foreach ($folders as $folder) {
                // Log deletion
                try {
                    AccessLog::create([
                        'user_id' => Auth::id(),
                        'action' => 'folder_deleted_bulk',
                        'description' => "Folder '{$folder->name}' deleted via bulk action.",
                        'ip_address' => request()->ip(),
                        'metadata' => ['folder_id' => $folder->id]
                    ]);
                } catch (\Exception $e) {
                }

                $folder->delete();
                $count++;
            }
        }

        // Delete Documents
        if (!empty($documentIds)) {
            $documents = Document::whereIn('id', $documentIds)->get();
            foreach ($documents as $document) {
                // Log deletion
                try {
                    AccessLog::create([
                        'user_id' => Auth::id(),
                        'action' => 'document_deleted_bulk',
                        'description' => "Document '{$document->title}' deleted via bulk action.",
                        'ip_address' => request()->ip(),
                        'metadata' => ['document_id' => $document->id]
                    ]);
                } catch (\Exception $e) {
                }

                $document->delete();
                $count++;
            }
        }

        // Notify stakeholders
        \App\Services\SystemNotificationService::broadcastNotification([
            'title' => 'Bulk Cleanup',
            'message' => "{$count} items have been removed from the vault.",
            'type' => 'warning',
            'category' => 'document',
            'severity' => 'medium',
            'action' => 'bulk_deleted'
        ]);

        return redirect()->back()->with('success', "{$count} items successfully deleted.");
    }

    public function bulkMove(Request $request)
    {
        $targetFolderId = $request->input('target_folder_id');
        // If target is empty, it means move to root (null)
        if (empty($targetFolderId)) {
            $targetFolderId = null;
        }

        $folderIds = $request->input('selected_folders', []);
        $documentIds = $request->input('selected_documents', []);
        $count = 0;

        // Move Folders
        if (!empty($folderIds)) {
            // Prevent moving a folder into itself or its own children is complex without recursion check.
            // For now, simple check: don't move if target is same as source
            $folders = \App\Models\Folder::whereIn('id', $folderIds)->get();
            foreach ($folders as $folder) {
                if ($folder->id != $targetFolderId) {
                    $folder->parent_id = $targetFolderId;
                    $folder->save();
                    $count++;
                }
            }
        }

        // Move Documents
        if (!empty($documentIds)) {
            Document::whereIn('id', $documentIds)->update(['folder_id' => $targetFolderId]);
            $count += count($documentIds);
        }

        // Notify stakeholders
        \App\Services\SystemNotificationService::broadcastNotification([
            'title' => 'Bulk Move',
            'message' => "{$count} items have been reorganized in the vault.",
            'type' => 'info',
            'category' => 'document',
            'severity' => 'low',
            'action' => 'bulk_moved'
        ]);

        return redirect()->back()->with('success', "{$count} items moved successfully.");
    }

    public function index()
    {
        // Exclude legal documents from general document management
        $documents = Document::with('uploader')
            ->whereNotIn('source', ['legal_management', 'legal_submission', 'ai_builder'])
            ->latest()
            ->get();
        return view('document.index', compact('documents'));
    }

    public function vaultIndex(Request $request)
    {
        // Vault specific index view (Root level)
        $query = Document::with('uploader')
            ->whereNotIn('source', ['legal_management', 'legal_submission', 'ai_builder'])
            ->whereNull('folder_id'); // Only root documents

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereJsonContains('tags', $search);
            });
        }

        // Filters
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }
        if ($department = $request->input('department')) {
            $query->where('department', $department);
        }
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $documents = $query->latest()->paginate(20)->withQueryString();

        $folders = \App\Models\Folder::whereNull('parent_id');

        // Search Folders
        if ($search = $request->input('search')) {
            $folders->where('name', 'like', "%{$search}%");
        }
        // Filter Folders by Department
        if ($department = $request->input('department')) {
            $folders->where('department', $department);
        }
        // Filter Folders by Category
        if ($category = $request->input('category')) {
            $folders->where('category', $category);
        }

        $folders = $folders->get();

        // Storage stats (Mock for UI)
        // Storage Dynamic Calculation (Estimated 15MB per doc)
        $avgSize = 15;
        $totalDocs = \App\Models\Document::count();

        // 1. Archives (All archived documents)
        $archivedDocs = \App\Models\Document::where('status', 'archived')->count();

        // 2. Active Contracts
        $activeContracts = \App\Models\Document::where('status', '!=', 'archived')
            ->where('category', 'contract')
            ->count();

        // 3. Active Media (Images/Videos based on crude file extension check)
        $activeMedia = \App\Models\Document::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->where('file_path', 'like', '%.jpg')
                    ->orWhere('file_path', 'like', '%.png')
                    ->orWhere('file_path', 'like', '%.jpeg')
                    ->orWhere('file_path', 'like', '%.mp4');
            })->count();

        // 4. Others (Everything else)
        // Total - (Archived + key categories)
        // Ensure no negative
        $othersDocs = max(0, $totalDocs - ($archivedDocs + $activeContracts + $activeMedia));

        $totalSizeMb = $totalDocs * $avgSize;
        $totalLimitMb = 1024000; // 1 TB

        $stats = [
            'total_size' => round($totalSizeMb / 1024, 2) . ' GB',
            'contracts_size' => round(($activeContracts * $avgSize) / 1024, 2) . ' GB',
            'media_size' => round(($activeMedia * $avgSize) / 1024, 2) . ' GB',
            'archives_size' => round(($archivedDocs * $avgSize) / 1024, 2) . ' GB',
            'others_size' => round(($othersDocs * $avgSize) / 1024, 2) . ' GB',
            'percent_used' => min(100, round(($totalSizeMb / $totalLimitMb) * 100, 2)),
        ];

        return view('vault.documents.index', compact('documents', 'folders', 'stats'));
    }

    public function view()
    {
        // Get all documents for the table view
        $documents = Document::with('uploader')
            ->whereNotIn('source', ['legal_management', 'legal_submission', 'ai_builder'])
            ->latest()
            ->paginate(20);

        return view('document.view', compact('documents'));
    }

    /**
     * Basic reports view for DMS
     */
    public function reports()
    {
        $documents = Document::whereNotIn('source', ['legal_management', 'legal_submission', 'ai_builder'])->get();
        $byDepartment = $documents->groupBy('department')->map->count();
        $byStatus = $documents->groupBy('status')->map->count();
        return view('document.reports', compact('byDepartment', 'byStatus'));
    }

    /**
     * Document receiving interface for DMS
     */
    public function receive()
    {
        $documents = Document::whereNotIn('source', ['legal_management', 'legal_submission', 'ai_builder'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('document.receive', compact('documents'));
    }

    public function create()
    {
        return view('document.create');
    }

    public function store(Request $request)
    {

        // Enhanced authentication check for all document types
        if (!Auth::check()) {
            \Log::warning('Authentication failed - Auth::check() returned false', [
                'session_id' => session()->getId(),
                'session_data' => session()->all(),
                'request_ip' => request()->ip(),
                'current_guard' => Auth::getDefaultDriver(),
                'all_guards' => array_keys(config('auth.guards'))
            ]);

            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required to upload documents.',
                    'debug_info' => [
                        'auth_check' => false,
                        'session_id' => session()->getId(),
                        'has_session' => session()->has('_token'),
                        'current_guard' => Auth::getDefaultDriver()
                    ]
                ]);
            }

            return redirect()->route('login')->with('error', 'Authentication required to upload documents.');
        }

        // Get authenticated user with enhanced validation
        $user = Auth::user();

        \Log::info('User object retrieved', [
            'user_class' => get_class($user),
            'user_id' => $user ? $user->id : 'null',
            'user_properties' => $user ? array_keys($user->toArray()) : 'null',
            'auth_check' => Auth::check(),
            'session_id' => session()->getId(),
            'current_guard' => Auth::getDefaultDriver(),
            'user_model_class' => config('auth.providers.users.model')
        ]);

        // Ensure we have a valid user ID - be more flexible about user types
        if (!$user) {
            \Log::error('No user object retrieved from Auth::user()', [
                'auth_check' => Auth::check(),
                'session_id' => session()->getId(),
                'request_ip' => request()->ip(),
                'current_guard' => Auth::getDefaultDriver()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error: No user found. Please log in again.',
                    'debug_info' => [
                        'auth_check' => Auth::check(),
                        'user_exists' => false,
                        'session_id' => session()->getId(),
                        'current_guard' => Auth::getDefaultDriver()
                    ]
                ]);
            }

            return redirect()->route('login')->with('error', 'Authentication error: No user found. Please log in again.');
        }

        // Check if user has an ID field (be flexible about the field name)
        $userId = null;
        if (isset($user->id)) {
            $userId = $user->id;
        } elseif (isset($user->Dept_no)) {
            $userId = $user->Dept_no;
        } elseif (isset($user->user_id)) {
            $userId = $user->user_id;
        }

        if (empty($userId)) {
            \Log::error('User object has no identifiable ID field', [
                'user_class' => get_class($user),
                'user_properties' => array_keys($user->toArray()),
                'auth_check' => Auth::check(),
                'session_id' => session()->getId(),
                'current_guard' => Auth::getDefaultDriver()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication error: Invalid user ID. Please log in again.',
                    'debug_info' => [
                        'auth_check' => Auth::check(),
                        'user_exists' => true,
                        'user_class' => get_class($user),
                        'user_properties' => array_keys($user->toArray()),
                        'session_id' => session()->getId(),
                        'current_guard' => Auth::getDefaultDriver()
                    ]
                ]);
            }

            return redirect()->back()->with('error', 'Authentication error: Invalid user ID. Please log in again.');
        }

        // Debug logging
        \Log::info('Document upload attempt', [
            'user_id' => $userId,
            'user_type' => get_class($user),
            'user_properties' => $user->toArray(),
            'request_source' => $request->source,
            'has_file' => $request->hasFile('document_file'),
            'auth_check' => Auth::check(),
            'session_id' => session()->getId(),
            'current_guard' => Auth::getDefaultDriver()
        ]);

        // Check user authorization for document upload
        if (!$this->isUserAuthorizedForUpload($user)) {
            AccessLog::create([
                'user_id' => $userId,
                'action' => 'unauthorized_upload_attempt',
                'description' => 'User attempted document upload without proper authorization',
                'ip_address' => request()->ip()
            ]);

            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied: You are not authorized to upload documents.'
                ]);
            }

            return redirect()->back()->with('error', 'Access Denied: You are not authorized to upload documents.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            // DMS metadata
            'confidentiality' => 'nullable|string|in:public,internal,restricted',
            'retention_policy' => 'nullable|string|in:none,30_days,6_months,1_year,3_years,custom',
            'retention_until' => 'nullable|date',
            'source' => 'nullable|string|in:document_management,legal_management,visitor_management,facility_management',
            'document_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png|max:10240',
            'folder_id' => 'nullable|exists:folders,id'
        ]);

        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        // Ensure uploaded_by is never null
        $uploadedBy = $userId;
        if (empty($uploadedBy)) {
            \Log::error('Critical: User ID is empty during document creation', [
                'user' => $user->toArray(),
                'auth_check' => Auth::check(),
                'session_id' => session()->getId(),
                'current_guard' => Auth::getDefaultDriver()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Critical error: User authentication failed. Please log in again.'
                ]);
            }

            return redirect()->back()->with('error', 'Critical error: User authentication failed. Please log in again.');
        }

        // Step 1: Create initial document record for tracking
        try {
            \Log::info('Creating document record', [
                'title' => $request->title,
                'uploaded_by' => $uploadedBy,
                'user_id' => $userId,
                'file_path' => $filePath
            ]);

            $document = Document::create([
                'title' => $request->title,
                'description' => $request->description,
                'department' => $request->department,
                'category' => $request->category ?? 'general', // Use AI-determined category if available
                'file_path' => $filePath,
                'uploaded_by' => $uploadedBy, // Use the validated user ID
                'status' => 'active',
                'source' => $request->source ?? 'document_management',
                'folder_id' => $request->folder_id, // Save folder_id
                'workflow_stage' => 'uploaded',
                'workflow_log' => [],
                'lifecycle_log' => [],
                // DMS fields
                'document_uid' => 'DOC-' . strtoupper(uniqid()),
                'confidentiality' => $request->input('confidentiality', 'internal'),
                'retention_until' => $request->input('retention_until'),
                'retention_policy' => $request->input('retention_policy')
            ]);

            \Log::info('Document record created successfully', [
                'document_id' => $document->id,
                'uploaded_by' => $document->uploaded_by,
                'title' => $document->title
            ]);

        } catch (\Exception $e) {
            \Log::error('Document creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => $userId,
                'uploaded_by' => $uploadedBy,
                'auth_check' => Auth::check(),
                'current_guard' => Auth::getDefaultDriver()
            ]);

            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating document: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()->with('error', 'Error creating document: ' . $e->getMessage());
        }

        // Log the initial upload step
        $this->logDocumentLifecycleStep($document, 'uploaded', [
            'user_id' => $userId ?? 'unknown',
            'file_name' => $fileName,
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType()
        ]);

        // Step 2: Perform AI Analysis for automatic classification
        try {
            // Extract text content for AI analysis
            $extractedText = $this->textExtractor->extractText($file);

            \Log::info('Document text extraction completed', [
                'document_id' => $document->id,
                'text_length' => strlen($extractedText),
                'has_text' => !empty($extractedText),
                'text_preview' => substr($extractedText, 0, 500),
                'text_ends_with_tmp' => str_ends_with($extractedText, 'tmp'),
                'text_contains_unknown' => str_contains($extractedText, 'Unknown document type')
            ]);

            // Validate extracted text before sending to AI
            if ($this->isValidExtractedText($extractedText)) {
                $document->update(['extracted_text' => $extractedText]);

                // Perform AI analysis using Gemini
                \Log::info('Starting Gemini AI analysis', [
                    'document_id' => $document->id,
                    'text_length' => strlen($extractedText),
                    'text_preview' => substr($extractedText, 0, 200)
                ]);

                $aiAnalysis = $this->geminiService->analyzeDocument($extractedText);

                \Log::info('Gemini AI analysis response received', [
                    'document_id' => $document->id,
                    'ai_response' => $aiAnalysis,
                    'has_error' => isset($aiAnalysis['error'])
                ]);

                if ($aiAnalysis && !isset($aiAnalysis['error'])) {
                    // Extract category from AI analysis
                    $aiCategory = $aiAnalysis['category'] ?? $aiAnalysis['CATEGORY'] ?? 'general';

                    \Log::info('AI analysis successful, updating document', [
                        'document_id' => $document->id,
                        'category' => $aiCategory,
                        'ai_analysis_keys' => array_keys($aiAnalysis)
                    ]);

                    // Update document with AI analysis results
                    $document->update([
                        'ai_analysis' => $aiAnalysis,
                        'category' => $aiCategory, // Update category based on AI analysis
                        'requires_legal_review' => $aiAnalysis['requires_legal_review'] ?? $aiAnalysis['LEGAL_REVIEW_REQUIRED'] === 'YES',
                        'requires_visitor_coordination' => $aiAnalysis['requires_visitor_coordination'] ?? $aiAnalysis['VISITOR_COORDINATION_REQUIRED'] === 'YES',
                        'legal_risk_score' => $aiAnalysis['legal_risk_score'] ?? $aiAnalysis['LEGAL_RISK_SCORE'] ?? 'Low'
                    ]);

                    // Send notification

                    $this->logDocumentLifecycleStep($document, 'ai_analysis_completed', [
                        'analysis_type' => 'gemini_ai',
                        'category' => $aiCategory,
                        'risk_score' => $aiAnalysis['legal_risk_score'] ?? $aiAnalysis['LEGAL_RISK_SCORE'] ?? 'Low',
                        'requires_legal_review' => $aiAnalysis['requires_legal_review'] ?? $aiAnalysis['LEGAL_REVIEW_REQUIRED'] === 'YES'
                    ]);

                    \Log::info('AI analysis completed successfully', [
                        'document_id' => $document->id,
                        'category' => $aiCategory,
                        'ai_analysis' => $aiAnalysis
                    ]);
                } else {
                    // Fallback if AI analysis fails
                    \Log::warning('AI analysis failed, using fallback', [
                        'document_id' => $document->id,
                        'error' => $aiAnalysis['error'] ?? 'Unknown error',
                        'ai_response' => $aiAnalysis
                    ]);

                    $this->logDocumentLifecycleStep($document, 'ai_analysis_failed', [
                        'error' => $aiAnalysis['error'] ?? 'Unknown error',
                        'fallback_category' => 'general'
                    ]);

                    \Log::warning('AI analysis failed, using fallback category', [
                        'document_id' => $document->id,
                        'error' => $aiAnalysis['error'] ?? 'Unknown error'
                    ]);
                }
            } else {
                // Text extraction failed or returned invalid content
                \Log::error('Text extraction failed or returned invalid content', [
                    'document_id' => $document->id,
                    'extracted_text' => $extractedText,
                    'text_length' => strlen($extractedText),
                    'file_type' => $file->getMimeType()
                ]);

                $this->logDocumentLifecycleStep($document, 'text_extraction_failed', [
                    'file_type' => $file->getMimeType(),
                    'extracted_text' => $extractedText,
                    'fallback_category' => 'general'
                ]);

                // Set a meaningful fallback category based on filename
                $fallbackCategory = $this->determineFallbackCategory($file->getClientOriginalName());
                $document->update(['category' => $fallbackCategory]);

                \Log::warning('Text extraction failed, using filename-based fallback category', [
                    'document_id' => $document->id,
                    'file_type' => $file->getMimeType(),
                    'fallback_category' => $fallbackCategory
                ]);
            }
        } catch (\Exception $e) {
            // Log AI analysis error but continue with document creation
            \Log::error('AI analysis error during document upload', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->logDocumentLifecycleStep($document, 'ai_analysis_error', [
                'error' => $e->getMessage(),
                'fallback_category' => 'general'
            ]);

            \Log::error('AI analysis error during document upload', [
                'document_id' => $document->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Create AccessLog entry for legal documents
        if ($request->source === 'legal_management') {
            AccessLog::create([
                'user_id' => $uploadedBy, // Use validated user ID
                'action' => 'legal_document_uploaded',
                'description' => "Legal document '{$request->title}' uploaded successfully",
                'ip_address' => request()->ip()
            ]);
        }

        // Step 4: Route document based on AI analysis
        $this->routeDocument($document, $document->ai_analysis);

        // Log successful upload using DeptAccount Dept_no if available
        try {
            $deptNo = null;
            if (!empty($uploadedBy)) {
                // $uploadedBy may already be Dept_no, try to map if it looks like employee_id
                if (is_string($uploadedBy) && !is_numeric($uploadedBy)) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $uploadedBy)->first())->Dept_no;
                } else {
                    $deptNo = $uploadedBy;
                }
            }
            if (!$deptNo && auth()->check()) {
                $email = auth()->user()->email ?? '';
                $empFromEmail = strstr($email, '@', true);
                if ($empFromEmail) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                }
            }
            AccessLog::create([
                'user_id' => $deptNo ?? 0,
                'action' => 'document_uploaded',
                'description' => 'Document uploaded: ' . $request->title,
                'ip_address' => request()->ip()
            ]);
        } catch (\Throwable $e) {
            // swallow logging errors
        }

        // Notify stakeholders for the successful upload
        \App\Services\SystemNotificationService::notifyDocumentAction('uploaded', $document);

        // Debug logging for successful upload
        \Log::info('Document uploaded successfully', [
            'document_id' => $document->id,
            'title' => $document->title,
            'uploaded_by' => $document->uploaded_by,
            'source' => $request->source,
            'is_ajax' => $request->ajax()
        ]);

        // Return response based on request type
        if ($request->ajax() || $request->wantsJson()) {
            // Refresh the document to get the latest data
            $document->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully!',
                'document' => [
                    'id' => $document->id,
                    'title' => $document->title,
                    'description' => $document->description,
                    'category' => $document->category,
                    'file_path' => $document->file_path,
                    'status' => $document->status,
                    'uploader_name' => $document->uploader_name,
                    'created_at' => $document->created_at
                ]
            ]);
        }

        if ($request->input('redirect_to') === 'vault') {
            if ($request->folder_id) {
                return redirect()->route('vault.folders.show', $request->folder_id)->with('success', 'Document uploaded successfully!');
            }
            return redirect()->route('vault.documents.index_new')->with('success', 'Document uploaded successfully!');
        }

        return redirect()->route('document.index')->with('success', 'Document uploaded successfully!');
    }

    private function routeDocument(Document $document, $aiAnalysis)
    {
        if (!$aiAnalysis || $aiAnalysis['error']) {
            // If AI analysis failed, keep archived status and mark stage
            $document->update(['workflow_stage' => 'ai_failed']);
            $document->logWorkflowStep('ai_analysis_failed', 'AI analysis failed, document archived');
            return;
        }

        $category = $aiAnalysis['category'] ?? 'general';
        $requiresLegalReview = $aiAnalysis['requires_legal_review'] ?? false;
        $requiresVisitorCoordination = $aiAnalysis['requires_visitor_coordination'] ?? false;

        // Route to Facility Reservations (FR) module
        if ($this->isFacilityReservationDocument($category, $aiAnalysis)) {
            $this->routeToFacilityReservations($document, $aiAnalysis);
        }
        // Route to Visitor Management (VM) module
        elseif ($requiresVisitorCoordination) {
            $this->routeToVisitorManagement($document, $aiAnalysis);
        }
        // Route to Legal Management (LM) module
        elseif ($requiresLegalReview) {
            $this->routeToLegalManagement($document, $aiAnalysis);
        }
        // Archive non-actionable documents
        else {
            $this->archiveDocument($document, $aiAnalysis);
        }
    }

    private function isFacilityReservationDocument($category, $aiAnalysis)
    {
        // Check if document contains facility reservation keywords
        $text = strtolower($aiAnalysis['summary'] ?? '') . ' ' . strtolower($aiAnalysis['key_info'] ?? '');
        $facilityKeywords = ['facility', 'room', 'conference', 'meeting', 'reservation', 'booking', 'schedule', 'venue'];

        foreach ($facilityKeywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function routeToFacilityReservations(Document $document, $aiAnalysis)
    {
        $document->update(['workflow_stage' => 'routed_fr']);
        $this->logDocumentLifecycleStep($document, 'routed_to_fr', [
            'target_module' => 'Facility Reservations',
            'ai_analysis_summary' => $aiAnalysis['summary'] ?? 'No summary available'
        ]);

        // Enhanced auto-scheduling as per TO BE diagram
        $autoScheduledReservation = $this->notificationService->autoScheduleFacilityAndNotify($document, $aiAnalysis);

        if ($autoScheduledReservation) {
            // Auto-scheduling successful
            $this->logDocumentLifecycleStep($document, 'auto_scheduled_successfully', [
                'reservation_id' => $autoScheduledReservation->id,
                'facility_name' => $autoScheduledReservation->facility->name ?? 'Unknown',
                'scheduled_time' => $autoScheduledReservation->start_time
            ]);
        } else {
            // Fallback to manual reservation creation
            $reservation = FacilityReservation::create([
                'facility_id' => 1, // Default facility - will be updated by user
                'reserved_by' => Auth::id(),
                'start_time' => now()->addDay(), // Default time - will be updated
                'end_time' => now()->addDay()->addHour(), // Default time - will be updated
                'purpose' => $aiAnalysis['summary'] ?? 'Document-based reservation',
                'status' => 'pending',
                'requester_name' => Auth::user()->name,
                'requester_contact' => Auth::user()->email,
                'workflow_stage' => 'document_processing',
                'document_id' => $document->id
            ]);

            // Link document to reservation
            $document->update(['workflow_stage' => 'linked_reservation']);

            // Dispatch job to process the reservation document
            ProcessReservationDocument::dispatch($reservation->id);

            $this->logDocumentLifecycleStep($document, 'manual_reservation_created', [
                'reservation_id' => $reservation->id,
                'reason' => 'Auto-scheduling not applicable or failed'
            ]);
        }

        // Log routing action
        AccessLog::create([
            'user_id' => Auth::id(),
            'action' => 'document_routed_to_fr_enhanced',
            'description' => 'Document routed to Facility Reservations with enhanced auto-scheduling. Document ID: ' . $document->id,
            'ip_address' => request()->ip()
        ]);

        $document->logWorkflowStep('routed_to_fr', 'Document routed to Facility Reservations module with auto-scheduling attempt');
    }

    private function routeToVisitorManagement(Document $document, $aiAnalysis)
    {
        $document->update(['workflow_stage' => 'routed_vm']);

        // Log routing action
        AccessLog::create([
            'user_id' => Auth::id(),
            'action' => 'document_routed_to_vm',
            'description' => 'Document routed to Visitor Management module for visitor coordination',
            'ip_address' => request()->ip()
        ]);

        $document->logWorkflowStep('routed_to_vm', 'Document routed to Visitor Management module');
    }

    private function routeToLegalManagement(Document $document, $aiAnalysis)
    {
        $document->update(['workflow_stage' => 'routed_lm']);
        $riskScore = $aiAnalysis['legal_risk_score'] ?? 'Low';

        $this->logDocumentLifecycleStep($document, 'routed_to_lm', [
            'target_module' => 'Legal Management',
            'risk_score' => $riskScore,
            'requires_review' => $aiAnalysis['requires_legal_review'] ?? false
        ]);

        // Enhanced legal processing as per TO BE diagram
        if ($riskScore === 'High' || ($aiAnalysis['requires_legal_review'] ?? false)) {
            // High-risk documents: Create case or legal memo
            $this->createLegalCaseOrMemo($document, $aiAnalysis);
            $this->logDocumentLifecycleStep($document, 'legal_case_created', [
                'risk_level' => 'high',
                'action_taken' => 'case_or_memo_creation'
            ]);
        } else {
            // Lower risk documents: Standard archive with legal review flag
            $document->update(['status' => 'archived_legal_review']);
            $this->logDocumentLifecycleStep($document, 'archived_with_legal_flag', [
                'risk_level' => 'low_to_medium',
                'action_taken' => 'archived_for_review'
            ]);
        }

        // Log comprehensive routing action
        AccessLog::create([
            'user_id' => Auth::id(),
            'action' => 'document_routed_to_lm_enhanced',
            'description' => "Document routed to Legal Management with enhanced processing. Risk Score: {$riskScore}, Action: " . ($riskScore === 'High' ? 'Case/Memo Creation' : 'Archive with Review'),
            'ip_address' => request()->ip()
        ]);

        $document->logWorkflowStep('routed_to_lm', 'Document routed to Legal Management module with risk-based processing');
    }

    /**
     * Create legal case or memo for high-risk documents
     */
    private function createLegalCaseOrMemo($document, $aiAnalysis)
    {
        try {
            // Determine document type for case/memo creation
            $category = $aiAnalysis['category'] ?? 'general';
            $riskScore = $aiAnalysis['legal_risk_score'] ?? 'High';

            // Create legal case entry
            $legalCase = [
                'case_title' => "Legal Review Required: " . $document->title,
                'case_description' => $this->generateLegalCaseDescription($document, $aiAnalysis),
                'priority' => $this->mapRiskScoreToPriority($riskScore),
                'source_document_id' => $document->id,
                'assigned_to' => $this->getDefaultLegalReviewer(),
                'status' => 'pending_review',
                'created_by' => Auth::id(),
                'legal_implications' => $aiAnalysis['legal_implications'] ?? 'Requires legal analysis',
                'compliance_status' => $aiAnalysis['compliance_status'] ?? 'review_required'
            ];

            // Store legal case information in document
            $document->update([
                'legal_case_data' => $legalCase,
                'workflow_stage' => 'legal_case_created'
            ]);

            $this->logDocumentLifecycleStep($document, 'legal_case_data_created', [
                'case_title' => $legalCase['case_title'],
                'priority' => $legalCase['priority'],
                'assigned_to' => $legalCase['assigned_to']
            ]);

            Log::info('Legal case created for high-risk document', [
                'document_id' => $document->id,
                'risk_score' => $riskScore,
                'case_title' => $legalCase['case_title']
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to create legal case for document', [
                'document_id' => $document->id,
                'error' => $e->getMessage()
            ]);

            $this->logDocumentLifecycleStep($document, 'legal_case_creation_failed', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate legal case description
     */
    private function generateLegalCaseDescription($document, $aiAnalysis)
    {
        $description = "Legal review required for document: " . $document->title . "\n\n";
        $description .= "AI Analysis Summary: " . ($aiAnalysis['summary'] ?? 'No summary available') . "\n\n";
        $description .= "Key Information: " . ($aiAnalysis['key_info'] ?? 'No key information extracted') . "\n\n";
        $description .= "Legal Risk Score: " . ($aiAnalysis['legal_risk_score'] ?? 'Unknown') . "\n";
        $description .= "Requires Legal Review: " . (($aiAnalysis['requires_legal_review'] ?? false) ? 'Yes' : 'No') . "\n";
        $description .= "Document Category: " . ($aiAnalysis['category'] ?? 'general') . "\n\n";
        $description .= "Please review this document for legal compliance and potential risks.";

        return $description;
    }

    /**
     * Map risk score to priority
     */
    private function mapRiskScoreToPriority($riskScore)
    {
        switch ($riskScore) {
            case 'High':
                return 'urgent';
            case 'Medium':
                return 'normal';
            default:
                return 'low';
        }
    }

    /**
     * Get default legal reviewer (can be enhanced to use role-based assignment)
     */
    private function getDefaultLegalReviewer()
    {
        // For now, return the current user or system
        return Auth::id() ?? 1;
    }

    private function archiveDocument(Document $document, $aiAnalysis)
    {
        $document->update(['workflow_stage' => 'archived']);

        // Log archiving action
        AccessLog::create([
            'user_id' => Auth::id(),
            'action' => 'document_archived',
            'description' => 'Document archived as non-actionable. Category: ' . ($aiAnalysis['category'] ?? 'Unknown'),
            'ip_address' => request()->ip()
        ]);

        $document->logWorkflowStep('archived', 'Document archived as non-actionable');
    }

    public function show($id)
    {
        $document = Document::with(['uploader', 'documentRequests.requester', 'documentRequests.approver'])
            ->findOrFail($id);

        // Check access permissions
        if (!$this->canAccessDocument(Auth::user(), $document)) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied: You do not have permission to view this document.'
                ], 403);
            }
            return redirect()->back()->with('error', 'Access Denied: You do not have permission to view this document.');
        }

        // Log access
        $this->logDocumentAccess($document, Auth::user(), 'view');

        // Check if user is administrator for action buttons
        $isAdmin = $this->isAdministrator(Auth::user());

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'document' => [
                    'id' => $document->id,
                    'title' => $document->title,
                    'description' => $document->description,
                    'type' => $document->type ?? $document->category, // Use category as type if type is null
                    'category' => $document->category,
                    'department' => $document->department,
                    'confidentiality' => $document->confidentiality,
                    'confidentiality_level' => $document->confidentiality_level ?? $document->confidentiality,
                    'retention_policy' => $document->retention_policy,
                    'retention_period' => $document->retention_period,
                    'retention_until' => $document->retention_until,
                    'status' => $document->status,
                    'file_path' => $document->file_path,
                    'created_at' => $document->created_at,
                    'updated_at' => $document->updated_at,
                    'last_edited_at' => $document->last_edited_at,
                    'uploader' => $document->uploader,
                    'ai_analysis' => $document->ai_analysis,
                    'view_count' => $document->view_count ?? 0,
                    'download_count' => $document->download_count ?? 0,
                    'is_admin' => $isAdmin
                ]
            ]);
        }

        return view('document.show', compact('document', 'isAdmin'));
    }

    public function edit($id)
    {
        // Check if user is administrator
        if (!$this->isAdministrator(Auth::user())) {
            return redirect()->back()->with('error', 'Access Denied: Only administrators can edit documents.');
        }

        $document = Document::where('source', 'document_management')->findOrFail($id);
        return view('document.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        // Check if user is administrator or authorized role
        if (!in_array(Auth::user()->role, ['Admin Manager', 'Owner'])) {
            return redirect()->back()->with('error', 'Access Denied: You do not have permission to update documents.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'confidentiality' => 'nullable|string|in:public,internal,restricted',
            'retention_policy' => 'nullable|string|in:none,30_days,6_months,1_year,3_years,custom',
            'retention_until' => 'nullable|date'
        ]);

        $document = Document::where('source', 'document_management')->findOrFail($id);

        // Store old values for comparison
        $oldValues = $document->only(['title', 'description', 'department', 'category', 'confidentiality', 'retention_policy', 'retention_until']);

        $document->update($request->only(['title', 'description', 'department', 'category', 'confidentiality', 'retention_policy', 'retention_until']));

        // Log the update to AccessLog
        $this->logDocumentAccess($document, Auth::user(), 'edited');

        // Log the update to workflow
        $document->logWorkflowStep('document_updated', 'Document updated by administrator', [
            'updated_by' => Auth::user()->name ?? Auth::user()->id,
            'updated_fields' => array_keys($request->only(['title', 'description', 'department', 'category', 'confidentiality', 'retention_policy', 'retention_until'])),
            'old_values' => $oldValues,
            'new_values' => $request->only(['title', 'description', 'department', 'category', 'confidentiality', 'retention_policy', 'retention_until'])
        ]);

        // Send notification
        \App\Services\SystemNotificationService::notifyDocumentAction('updated', $document);

        return redirect()->route('document.show', $id)->with('success', 'Document updated successfully!');
    }

    public function destroy($id)
    {
        // Check if user is administrator
        if (!$this->isAdministrator(Auth::user())) {
            return redirect()->back()->with('error', 'Access Denied: Only administrators can delete documents.');
        }

        try {
            $document = Document::where('source', 'document_management')->findOrFail($id);

            // Delete file from storage
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Store title before deletion for notification
            $documentTitle = $document->title;

            // Log deletion before actual delete
            AccessLog::create([
                'user_id' => Auth::id() ?? 'unknown',
                'action' => 'document_deleted',
                'description' => "Document '{$documentTitle}' (ID: {$id}) deleted by administrator",
                'ip_address' => request()->ip()
            ]);

            $document->delete();

            // Send notification
            \App\Services\SystemNotificationService::notifyDocumentAction('deleted', (object) ['title' => $documentTitle]);

            // If the request is AJAX/JSON, return a JSON response for the frontend fetch()
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document deleted successfully!'
                ]);
            }

            return redirect()->route('document.index')->with('success', 'Document deleted successfully!');
        } catch (\Throwable $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting document: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error deleting document: ' . $e->getMessage());
        }
    }

    public function requestRelease($id)
    {
        $document = Document::where('source', 'document_management')->findOrFail($id);

        // Check if document is archived
        if ($document->status !== 'archived') {
            return redirect()->back()->with('error', 'Document is not available for release request.');
        }

        // Check if there's already a pending request
        $existingRequest = DocumentRequest::where('document_id', $id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return redirect()->back()->with('error', 'A release request is already pending for this document.');
        }

        DocumentRequest::create([
            'document_id' => $id,
            'requested_by' => Auth::id(),
            'status' => 'pending'
        ]);

        $document->update(['status' => 'pending_release']);

        return redirect()->route('document.show', $id)->with('success', 'Release request submitted successfully!');
    }

    public function download($id)
    {
        try {
            // Find document - allow all sources (document_management, legal_management, etc.)
            // This handles both regular and archived documents
            $document = Document::findOrFail($id);

            // Check access permissions
            if (!$this->canAccessDocument(Auth::user(), $document)) {
                return redirect()->back()->with('error', 'Access Denied: You do not have permission to download this document.');
            }

            // Log download access
            $this->logDocumentAccess($document, Auth::user(), 'download');

            // Always download as PDF
            $filePath = $document->file_path;
            $publicDisk = Storage::disk('public');

            // Normalize file path - remove leading slashes if present
            $filePath = ltrim($filePath, '/');

            // Try to find the actual file
            $actualFilePath = null;
            $fullPath = null;

            // Try public disk first (most common case)
            if ($publicDisk->exists($filePath)) {
                $actualFilePath = $filePath;
                $fullPath = storage_path('app/public/' . $filePath);
            } else {
                // Try with documents/ prefix
                $documentsPath = 'documents/' . $filePath;
                if ($publicDisk->exists($documentsPath)) {
                    $actualFilePath = $documentsPath;
                    $fullPath = storage_path('app/public/' . $documentsPath);
                } else {
                    // Try direct file path check
                    $directPath = storage_path('app/public/' . $filePath);
                    if (file_exists($directPath) && is_file($directPath)) {
                        $actualFilePath = $filePath;
                        $fullPath = $directPath;
                    }
                }
            }

            // Check if file is already PDF
            if ($fullPath && file_exists($fullPath)) {
                $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

                if ($extension === 'pdf') {
                    // File is already PDF, download it directly
                    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $document->title) . '.pdf';
                    return response()->download($fullPath, $filename, [
                        'Content-Type' => 'application/pdf',
                    ]);
                }
            }

            // File is not PDF or file not found - generate PDF wrapper
            return $this->generatePdfDownload($document, $fullPath);

        } catch (\Exception $e) {
            \Log::error('Document download error', [
                'document_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while downloading the document. Please try again.');
        }
    }

    public function preview($id)
    {
        try {
            $document = Document::findOrFail($id);

            // Check access permissions
            if (!$this->canAccessDocument(Auth::user(), $document)) {
                return response()->json(['error' => 'Access Denied'], 403);
            }

            // Log preview access
            $this->logDocumentAccess($document, Auth::user(), 'preview');

            $filePath = $document->file_path;
            $publicDisk = Storage::disk('public');
            $fullPath = null;

            // Normalize and find file (similar logic to download)
            $filePath = ltrim($filePath, '/');
            if ($publicDisk->exists($filePath)) {
                $fullPath = storage_path('app/public/' . $filePath);
            } else {
                $documentsPath = 'documents/' . $filePath;
                if ($publicDisk->exists($documentsPath)) {
                    $fullPath = storage_path('app/public/' . $documentsPath);
                } else {
                    $directPath = storage_path('app/public/' . $filePath);
                    if (file_exists($directPath) && is_file($directPath)) {
                        $fullPath = $directPath;
                    }
                }
            }

            if (!$fullPath || !file_exists($fullPath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $mimeType = mime_content_type($fullPath);

            // Only allow preview for safe types
            if (!in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'text/plain'])) {
                // For other types, return a message or force download (but this is preview, so maybe just an error or icon)
                return response()->file($fullPath); // Browser will handle or download if it can't display
            }

            return response()->file($fullPath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $document->title . '.' . pathinfo($fullPath, PATHINFO_EXTENSION) . '"'
            ]);

        } catch (\Exception $e) {
            \Log::error('Document preview error', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * Generate PDF download for document
     */
    private function generatePdfDownload($document, $originalFilePath = null)
    {
        try {
            // Get document content
            $content = '';
            $hasOriginalFile = false;

            if ($originalFilePath && file_exists($originalFilePath)) {
                $hasOriginalFile = true;
                $fileSize = filesize($originalFilePath);
                $fileSizeFormatted = $this->formatFileSize($fileSize);
                $extension = strtoupper(pathinfo($originalFilePath, PATHINFO_EXTENSION));

                // Try to extract text if possible
                try {
                    $textExtractor = new DocumentTextExtractorService();
                    $extractedText = $textExtractor->extractText($originalFilePath);
                    if (!empty($extractedText) && strlen($extractedText) > 50) {
                        $content = '<div class="document-content"><h3>Document Content</h3><div class="content-text">' . nl2br(htmlspecialchars(substr($extractedText, 0, 5000))) . (strlen($extractedText) > 5000 ? '...' : '') . '</div></div>';
                    }
                } catch (\Exception $e) {
                    \Log::warning('Could not extract text from document', ['error' => $e->getMessage()]);
                }

                $fileInfo = '<div class="file-info"><p><strong>Original File:</strong> ' . htmlspecialchars(basename($originalFilePath)) . '</p><p><strong>File Type:</strong> ' . htmlspecialchars($extension) . '</p><p><strong>File Size:</strong> ' . htmlspecialchars($fileSizeFormatted) . '</p></div>';
            } else {
                $fileInfo = '<div class="file-info"><p><em>Original file not available</em></p></div>';
            }

            // Get document description
            $description = !empty($document->description) ? '<div class="description"><h3>Description</h3><p>' . nl2br(htmlspecialchars($document->description)) . '</p></div>' : '';

            // Create HTML for PDF
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>' . htmlspecialchars($document->title) . '</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 40px; 
                        line-height: 1.6; 
                        color: #333;
                    }
                    .header { 
                        text-align: center; 
                        margin-bottom: 40px; 
                        border-bottom: 3px solid #1E3A8A;
                        padding-bottom: 20px;
                    }
                    h1 { 
                        color: #1E3A8A; 
                        margin: 0;
                        font-size: 24px;
                    }
                    .document-info { 
                        background: #F8F9FA; 
                        padding: 20px; 
                        border-left: 4px solid #F7B32B; 
                        margin-bottom: 30px;
                        border-radius: 4px;
                    }
                    .document-info p {
                        margin: 8px 0;
                    }
                    .document-info strong {
                        color: #1E3A8A;
                        min-width: 150px;
                        display: inline-block;
                    }
                    .file-info {
                        background: #E8F4F8;
                        padding: 15px;
                        border-radius: 4px;
                        margin: 20px 0;
                    }
                    .description {
                        margin: 20px 0;
                    }
                    .description h3 {
                        color: #1E3A8A;
                        margin-bottom: 10px;
                    }
                    .document-content {
                        margin: 20px 0;
                    }
                    .document-content h3 {
                        color: #1E3A8A;
                        margin-bottom: 10px;
                    }
                    .content-text {
                        background: #F8F9FA;
                        padding: 15px;
                        border-radius: 4px;
                        white-space: pre-wrap;
                        font-size: 12px;
                        max-height: 400px;
                        overflow: hidden;
                    }
                    .footer { 
                        margin-top: 50px; 
                        text-align: center; 
                        font-size: 11px; 
                        color: #7f8c8d;
                        border-top: 1px solid #E0E0E0;
                        padding-top: 20px;
                    }
                    .badge {
                        display: inline-block;
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 11px;
                        font-weight: 600;
                        margin-left: 8px;
                    }
                    .badge-archived {
                        background: #F7B32B;
                        color: #1E3A8A;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>' . htmlspecialchars($document->title) . '</h1>
                    <p style="color: #666; margin-top: 10px;">Document ID: #' . htmlspecialchars($document->id) . '</p>
                </div>
                
                <div class="document-info">
                    <p><strong>Document ID:</strong> #' . htmlspecialchars($document->id) . '</p>
                    <p><strong>Title:</strong> ' . htmlspecialchars($document->title) . '</p>
                    <p><strong>Category:</strong> ' . htmlspecialchars($document->category ?? 'N/A') . '</p>
                    <p><strong>Type:</strong> ' . htmlspecialchars($document->type ?? $document->category ?? 'N/A') . '</p>
                    <p><strong>Department:</strong> ' . htmlspecialchars($document->department ?? 'N/A') . '</p>
                    <p><strong>Confidentiality:</strong> ' . htmlspecialchars($document->confidentiality_level ?? $document->confidentiality ?? 'N/A') . '</p>
                    <p><strong>Status:</strong> ' . htmlspecialchars(ucfirst($document->status ?? 'N/A')) . ' <span class="badge badge-archived">' . htmlspecialchars(ucfirst($document->status ?? '')) . '</span></p>
                    <p><strong>Created:</strong> ' . ($document->created_at ? $document->created_at->format('F j, Y \a\t g:i A') : 'N/A') . '</p>
                    ' . ($document->archived_at ? '<p><strong>Archived:</strong> ' . $document->archived_at->format('F j, Y \a\t g:i A') . '</p>' : '') . '
                    ' . ($document->retention_until ? '<p><strong>Retention Until:</strong> ' . $document->retention_until->format('F j, Y') . '</p>' : '') . '
                </div>
                
                ' . $fileInfo . '
                
                ' . $description . '
                
                ' . $content . '
                
                <div class="footer">
                    <p>Generated on ' . now()->format('F j, Y \a\t g:i A') . '</p>
                    <p>Soliera Document Management System</p>
                    <p style="margin-top: 10px; color: #999;">This PDF was generated from the archived document repository.</p>
                </div>
            </body>
            </html>';

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html);
            $pdf->setPaper('A4', 'portrait');

            // Clean filename - remove special characters
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $document->title) . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('PDF generation failed', [
                'document_id' => $document->id,
                'error' => $e->getMessage()
            ]);

            // Fallback: return error
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Format file size in human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function analyze($id)
    {
        $document = Document::where('source', 'document_management')->findOrFail($id);

        // Extract text from document using DocumentTextExtractorService
        $filePath = storage_path('app/public/' . $document->file_path);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $documentText = $this->textExtractor->extractText($filePath);

        if (!$documentText) {
            return redirect()->back()->with('error', 'Could not extract text from document.');
        }

        try {
            $aiAnalysis = $this->geminiService->analyzeDocument($documentText);

            if ($aiAnalysis['error']) {
                return redirect()->back()->with('error', 'AI analysis failed: ' . $aiAnalysis['message']);
            }

            // Update document with AI analysis
            $document->update([
                'ai_analysis' => $aiAnalysis,
                'category' => $aiAnalysis['category'],
                'requires_legal_review' => $aiAnalysis['requires_legal_review'] ?? false,
                'requires_visitor_coordination' => $aiAnalysis['requires_visitor_coordination'] ?? false,
                'legal_risk_score' => $aiAnalysis['legal_risk_score'] ?? 'Low'
            ]);

            // Re-route document based on new analysis
            $this->routeDocument($document, $aiAnalysis);

            return redirect()->route('document.show', $id)->with('success', 'Document analyzed and re-routed successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'AI analysis failed: ' . $e->getMessage());
        }
    }

    /**
     * Analyze an existing stored legal document via AJAX and return JSON.
     * This mirrors analyze() but never redirects; it always returns a JSON
     * payload and gracefully falls back when OCR/AI fails so the UI never sees 500s.
     */
    public function analyzeAjax($id)
    {
        try {
            $document = Document::findOrFail($id);

            // Validate file exists; if missing, we will still attempt analysis using stored data
            $filePath = storage_path('app/public/' . $document->file_path);
            $fileExists = file_exists($filePath);

            // Extract text using the extractor service with safe fallback
            $documentText = '';
            if ($fileExists) {
                try {
                    $documentText = $this->textExtractor->extractText($filePath);
                } catch (\Throwable $e) {
                    \Log::warning('OCR extraction failed, will try stored text / metadata', [
                        'document_id' => $document->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                \Log::warning('AnalyzeAjax: File missing, using stored text/metadata fallback', [
                    'document_id' => $document->id,
                    'file_path' => $document->file_path
                ]);
            }

            if (empty($documentText)) {
                // If we have previously stored extracted_text use it first
                if (!empty($document->extracted_text)) {
                    $documentText = $document->extracted_text;
                } else {
                    // Ensure we always have text to classify – use metadata
                    $meta = trim(($document->title ?? '') . ' ' . ($document->description ?? ''));
                    $documentText = ($meta !== '') ? $meta : 'general document content - filename: ' . basename($document->file_path ?? 'document');
                }
            }

            // Run AI with graceful fallback
            try {
                $aiAnalysis = $this->geminiService->analyzeDocumentEnhanced($documentText);
            } catch (\Throwable $e) {
                \Log::error('Enhanced Gemini analysis threw unexpectedly, using fallback', [
                    'document_id' => $document->id,
                    'error' => $e->getMessage()
                ]);
                $aiAnalysis = app(\App\Services\GeminiService::class)->enhancedFallbackAnalysisWithViolations($documentText);
            }

            if (isset($aiAnalysis['error']) && $aiAnalysis['error']) {
                // Convert to non-error by using fallback
                $aiAnalysis = app(\App\Services\GeminiService::class)->fallbackAnalysis($documentText);
            }

            // Optionally persist latest analysis to the document record
            try {
                $updateData = [
                    'ai_analysis' => $aiAnalysis,
                    'category' => $aiAnalysis['category'] ?? ($document->category ?? 'general'),
                    'requires_legal_review' => $aiAnalysis['requires_legal_review'] ?? false,
                    'legal_risk_score' => $aiAnalysis['legal_risk_score'] ?? ($document->legal_risk_score ?? 'Low'),
                    'ai_analysis_completed' => true,
                    'ai_analysis_date' => now()
                ];

                // Add enhanced AI fields if available
                if (isset($aiAnalysis['ai_classification'])) {
                    $updateData['ai_classification'] = $aiAnalysis['ai_classification'];
                }
                if (isset($aiAnalysis['confidence'])) {
                    $updateData['ai_confidence'] = $aiAnalysis['confidence'];
                }
                if (isset($aiAnalysis['violation_score'])) {
                    $updateData['violation_score'] = $aiAnalysis['violation_score'];
                }
                if (isset($aiAnalysis['violation_details'])) {
                    $updateData['violation_details'] = $aiAnalysis['violation_details'];
                }
                if (isset($aiAnalysis['flagged_issues'])) {
                    $updateData['flagged_issues'] = $aiAnalysis['flagged_issues'];
                }
                if (isset($aiAnalysis['compliance_status'])) {
                    $updateData['compliance_status'] = $aiAnalysis['compliance_status'];
                }
                if (isset($aiAnalysis['compliance_details'])) {
                    $updateData['compliance_details'] = $aiAnalysis['compliance_details'];
                }
                if (isset($aiAnalysis['regulatory_standards'])) {
                    $updateData['regulatory_standards'] = $aiAnalysis['regulatory_standards'];
                }
                if (isset($aiAnalysis['ai_tags'])) {
                    $updateData['ai_tags'] = $aiAnalysis['tags'] ?? $aiAnalysis['ai_tags'];
                }
                if (isset($aiAnalysis['ai_insights'])) {
                    $updateData['ai_insights'] = $aiAnalysis['ai_insights'];
                }
                if (isset($aiAnalysis['requires_immediate_review'])) {
                    $updateData['requires_immediate_review'] = $aiAnalysis['requires_immediate_review'];
                }
                if (isset($aiAnalysis['violation_analysis'])) {
                    $updateData['alert_reasons'] = [
                        'violation_analysis' => $aiAnalysis['violation_analysis'],
                        'violation_score' => $aiAnalysis['violation_score'] ?? 'Low',
                        'flagged_issues' => $aiAnalysis['flagged_issues'] ?? []
                    ];
                }

                $document->update($updateData);
            } catch (\Throwable $e) {
                // Non-fatal if persisting fails
                \Log::warning('Failed to persist enhanced AI analysis on document', [
                    'document_id' => $document->id,
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'analysis' => $aiAnalysis
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found.'
            ], 404);
        } catch (\Throwable $e) {
            \Log::error('Unexpected error in analyzeAjax', [
                'document_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function analyzeUpload(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('AI Analysis request received', [
                'has_file' => $request->hasFile('document_file'),
                'file_name' => $request->file('document_file') ? $request->file('document_file')->getClientOriginalName() : 'no file',
                'file_size' => $request->file('document_file') ? $request->file('document_file')->getSize() : 'no file',
                'file_type' => $request->file('document_file') ? $request->file('document_file')->getMimeType() : 'no file',
                'all_data' => $request->all()
            ]);

            // Validate the request
            $request->validate([
                'document_file' => 'required|file|max:10240'
            ]);

            $file = $request->file('document_file');

            if (!$file || !$file->isValid()) {
                \Log::error('File validation failed', [
                    'file' => $file ? $file->getClientOriginalName() : 'null',
                    'is_valid' => $file ? $file->isValid() : 'null',
                    'error' => $file ? $file->getError() : 'null'
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid file uploaded'
                ], 422);
            }

            // Extract text with better error handling
            $documentText = '';
            try {
                $documentText = $this->textExtractor->extractText($file->getRealPath());
                \Log::info('Text extraction completed', [
                    'file_path' => $file->getRealPath(),
                    'text_length' => strlen($documentText),
                    'text_preview' => substr($documentText, 0, 200)
                ]);
            } catch (\Exception $e) {
                \Log::warning('Text extraction failed, using fallback', [
                    'error' => $e->getMessage(),
                    'file_path' => $file->getRealPath()
                ]);
                $documentText = 'general document content - filename: ' . $file->getClientOriginalName();
            }

            // Ensure we always have some text to classify
            if (empty($documentText)) {
                $documentText = 'general document content - filename: ' . $file->getClientOriginalName();
            }

            // Perform AI analysis
            try {
                \Log::info('Starting Gemini AI analysis', [
                    'text_length' => strlen($documentText),
                    'text_preview' => substr($documentText, 0, 100)
                ]);

                $aiAnalysis = $this->geminiService->analyzeDocument($documentText);

                \Log::info('Gemini AI analysis completed', [
                    'has_error' => isset($aiAnalysis['error']),
                    'analysis_keys' => array_keys($aiAnalysis)
                ]);

                // Guarantee a result: if remote analysis fails, use local fallback
                if (isset($aiAnalysis['error']) && $aiAnalysis['error']) {
                    \Log::warning('Gemini AI failed, using fallback analysis');
                    $aiAnalysis = app(\App\Services\GeminiService::class)->fallbackAnalysis($documentText);
                }

                return response()->json([
                    'success' => true,
                    'analysis' => $aiAnalysis
                ]);
            } catch (\Throwable $e) {
                \Log::error('AI analysis failed, using fallback', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                $aiAnalysis = app(\App\Services\GeminiService::class)->fallbackAnalysis($documentText);
                return response()->json([
                    'success' => true,
                    'analysis' => $aiAnalysis,
                    'fallback' => true,
                    'warning' => 'AI analysis failed, using fallback classification'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in analyzeUpload', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Unexpected error in analyzeUpload', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk upload multiple documents
     */
    public function bulkUpload(Request $request)
    {
        if (!Auth::check()) {
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required to upload documents.'
                ]);
            }

            return redirect()->route('login')->with('error', 'Authentication required to upload documents.');
        }

        $request->validate([
            'category' => 'nullable|string|max:255',
            'description_template' => 'nullable|string',
            'document_files.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png|max:10240'
        ]);

        $user = Auth::user();
        $uploadedCount = 0;
        $errors = [];

        foreach ($request->file('document_files') as $file) {
            try {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('documents', $fileName, 'public');

                // Create document record
                $document = Document::create([
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'description' => $request->description_template,
                    'category' => $request->category,
                    'file_path' => $filePath,
                    'uploaded_by' => $user->Dept_no ?? $user->id,
                    'status' => 'active',
                    'source' => 'legal_management',
                    'workflow_stage' => 'uploaded',
                    'workflow_log' => [],
                    'lifecycle_log' => []
                ]);

                // Log the upload
                $this->logDocumentLifecycleStep($document, 'bulk_uploaded', [
                    'user_id' => $user->Dept_no ?? $user->id,
                    'file_name' => $fileName,
                    'file_size' => $file->getSize(),
                    'file_type' => $file->getMimeType()
                ]);

                $uploadedCount++;
            } catch (\Exception $e) {
                $errors[] = "Failed to upload {$file->getClientOriginalName()}: " . $e->getMessage();
            }
        }

        // Log bulk upload action
        AccessLog::create([
            'user_id' => $user->Dept_no ?? $user->id,
            'action' => 'bulk_document_upload',
            'description' => "Bulk uploaded {$uploadedCount} legal documents",
            'ip_address' => request()->ip()
        ]);

        if (count($errors) > 0) {
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully uploaded {$uploadedCount} documents. Some documents failed to upload: " . implode(', ', $errors)
                ]);
            }

            return redirect()->route('legal.legal_documents')
                ->with('success', "Successfully uploaded {$uploadedCount} documents")
                ->with('error', "Some documents failed to upload: " . implode(', ', $errors));
        }

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Successfully uploaded {$uploadedCount} legal documents!"
            ]);
        }

        return redirect()->route('legal.legal_documents')
            ->with('success', "Successfully uploaded {$uploadedCount} legal documents!");
    }

    /**
     * Check if user is authorized for document upload
     */
    private function isUserAuthorizedForUpload($user)
    {
        // Allow all authenticated users for now, but log the access
        // In production, this could check specific roles or permissions

        // Ensure we have a valid user_id for logging
        $userId = $user->Dept_no ?? $user->id ?? 'unknown';

        AccessLog::create([
            'user_id' => $userId,
            'action' => 'authorization_check_passed',
            'description' => 'User passed authorization check for document upload',
            'ip_address' => request()->ip()
        ]);
        return true;
    }

    /**
     * Enhanced document lifecycle tracking with OCR quality assessment
     */
    private function logDocumentLifecycleStep($document, $step, $details = [])
    {
        $lifecycleLog = $document->lifecycle_log ?? [];
        // Prefer DeptAccount Dept_no over Laravel user id for audit trail
        $userId = null;
        try {
            $empId = session('emp_id');
            if ($empId) {
                $userId = optional(\App\Models\DeptAccount::where('employee_id', $empId)->first())->Dept_no;
            }
            if (!$userId && Auth::check()) {
                $email = Auth::user()->email ?? '';
                $empFromEmail = strstr($email, '@', true);
                if ($empFromEmail) {
                    $userId = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                }
            }
        } catch (\Throwable $e) {
            $userId = null;
        }
        $userId = $userId ?? 'unknown';

        // Add OCR quality assessment if this is a text extraction step
        if ($step === 'text_extraction_completed' && isset($details['extracted_text'])) {
            $details['ocr_quality'] = $this->assessExtractionQuality($details['extracted_text']);
            $details['text_validation_passed'] = $this->isValidExtractedText($details['extracted_text']);
        }

        $lifecycleLog[] = [
            'step' => $step,
            'timestamp' => now()->toISOString(),
            'user_id' => $userId,
            'details' => $details,
            'ip_address' => request()->ip()
        ];

        $document->update(['lifecycle_log' => $lifecycleLog]);

        // Also log to AccessLog for audit trail
        try {
            AccessLog::create([
                'user_id' => $userId,
                'action' => 'document_lifecycle_' . $step,
                'description' => "Document lifecycle: {$step} for document ID {$document->id}",
                'ip_address' => request()->ip()
            ]);
        } catch (\Throwable $e) {
            // swallow logging errors
        }
    }

    /**
     * Update document status with comprehensive tracking
     */
    private function updateDocumentStatus($document, $status, $reason = '')
    {
        $oldStatus = $document->status;
        $document->update(['status' => $status]);

        $this->logDocumentLifecycleStep($document, 'status_update', [
            'old_status' => $oldStatus,
            'new_status' => $status,
            'reason' => $reason
        ]);
    }

    /**
     * Determine routing decision based on TO BE diagram logic
     */
    private function determineRoutingDecision($document, $aiAnalysis)
    {
        if (!$aiAnalysis || $aiAnalysis['error']) {
            return [
                'route' => 'non_actionable',
                'target_module' => null,
                'reason' => 'AI analysis failed - document archived'
            ];
        }

        $category = $aiAnalysis['category'] ?? 'general';
        $requiresLegalReview = $aiAnalysis['requires_legal_review'] ?? false;
        $requiresVisitorCoordination = $aiAnalysis['requires_visitor_coordination'] ?? false;
        $riskScore = $aiAnalysis['legal_risk_score'] ?? 'Low';

        // Priority routing logic as per TO BE diagram:

        // 1. High-risk legal documents go to LM
        if ($riskScore === 'High' || $requiresLegalReview) {
            return [
                'route' => 'actionable',
                'target_module' => 'LM',
                'reason' => "High legal risk ({$riskScore}) or requires legal review"
            ];
        }

        // 2. Facility reservation documents go to FR
        if ($this->isFacilityReservationDocument($category, $aiAnalysis)) {
            return [
                'route' => 'actionable',
                'target_module' => 'FR',
                'reason' => 'Contains facility reservation content'
            ];
        }

        // 3. Visitor coordination documents go to VM
        if ($requiresVisitorCoordination) {
            return [
                'route' => 'actionable',
                'target_module' => 'VM',
                'reason' => 'Requires visitor coordination'
            ];
        }

        // 4. Medium-risk legal documents to LM
        if ($riskScore === 'Medium') {
            return [
                'route' => 'actionable',
                'target_module' => 'LM',
                'reason' => "Medium legal risk requires review"
            ];
        }

        // 5. All other documents are archived as non-actionable
        return [
            'route' => 'non_actionable',
            'target_module' => null,
            'reason' => "Low risk general document - no specific action required"
        ];
    }

    /**
     * Edit legal document
     */
    public function editLegalDocument($id)
    {
        $document = Document::where('source', 'legal_management')->findOrFail($id);
        return view('legal.edit_document', compact('document'));
    }

    /**
     * Update legal document
     */
    public function updateLegalDocument(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255'
        ]);

        $document = Document::where('source', 'legal_management')->findOrFail($id);
        $document->update($request->all());

        // Log the update (use DeptAccount Dept_no)
        try {
            $deptNo = null;
            $empId = session('emp_id');
            if ($empId) {
                $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empId)->first())->Dept_no;
            }
            if (!$deptNo && Auth::check()) {
                $email = Auth::user()->email ?? '';
                $empFromEmail = strstr($email, '@', true);
                if ($empFromEmail) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                }
            }
            AccessLog::create([
                'user_id' => $deptNo ?? 0,
                'action' => 'legal_document_updated',
                'description' => "Updated legal document: {$document->title}",
                'ip_address' => request()->ip()
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Legal document updated successfully!'
            ]);
        }

        return redirect()->route('legal.legal_documents')->with('success', 'Legal document updated successfully!');
    }

    /**
     * Archive legal document (No Deletion, Archive Only)
     */
    public function archiveLegalDocument($id)
    {
        try {
            $document = Document::where('source', 'legal_management')->findOrFail($id);

            // Check if already archived
            if ($document->status === 'archived') {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Document is already archived!'
                    ]);
                }
                return redirect()->route('legal.legal_documents')->with('error', 'Document is already archived!');
            }

            // Direct database update to ensure it's saved
            $archivedAt = now();
            $retentionYears = $document->getDefaultRetentionYears();
            $disposalDate = $archivedAt->copy()->addYears($retentionYears);

            // Update directly in database
            $updated = \DB::table('documents')
                ->where('id', $document->id)
                ->update([
                    'status' => 'archived',
                    'archived_at' => $archivedAt,
                    'retention_years' => $retentionYears,
                    'disposal_date' => $disposalDate,
                    'can_dispose' => false,
                    'disposal_reason' => 'Administrative archive',
                    'updated_at' => now()
                ]);

            if ($updated === 0) {
                throw new \Exception('Failed to update document in database');
            }

            // Also use the model method for consistency
            $document->archiveWithRetention();

            // Force save to ensure database is updated
            $document->save();

            // Refresh from database to get latest values
            $document->refresh();

            // Verify the document was actually archived
            $verification = \DB::table('documents')
                ->where('id', $document->id)
                ->where(function ($q) {
                    $q->where('status', 'archived')
                        ->orWhereNotNull('archived_at');
                })
                ->first();

            if (!$verification) {
                \Log::error('Archive verification failed', [
                    'document_id' => $document->id,
                    'status' => $document->status,
                    'archived_at' => $document->archived_at,
                    'db_status' => \DB::table('documents')->where('id', $document->id)->value('status'),
                    'db_archived_at' => \DB::table('documents')->where('id', $document->id)->value('archived_at')
                ]);
                throw new \Exception('Failed to archive document - verification failed');
            }

            \Log::info('Document archived successfully', [
                'document_id' => $document->id,
                'title' => $document->title,
                'status' => $document->status,
                'archived_at' => $document->archived_at,
                'db_verified' => true
            ]);

            // Safe archiving log (non-fatal if logging fails) - use DeptAccount Dept_no
            try {
                $deptNo = null;
                $empId = session('emp_id');
                if ($empId) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empId)->first())->Dept_no;
                }
                if (!$deptNo && Auth::check()) {
                    $email = Auth::user()->email ?? '';
                    $empFromEmail = strstr($email, '@', true);
                    if ($empFromEmail) {
                        $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                    }
                }
                AccessLog::create([
                    'user_id' => $deptNo ?? 0,
                    'action' => 'legal_document_archived',
                    'description' => "Archived legal document: {$document->title} (Disposal: {$document->disposal_date->format('Y-m-d')})",
                    'ip_address' => request()->ip()
                ]);
            } catch (\Throwable $e) {
                \Log::warning('Failed to log archiving for legal document', [
                    'id' => $document->id,
                    'error' => $e->getMessage()
                ]);
            }

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Legal document archived successfully! Disposal date: ' . $document->disposal_date->format('Y-m-d'),
                    'document_id' => $document->id,
                    'status' => $document->status,
                    'archived_at' => $document->archived_at ? $document->archived_at->toDateTimeString() : null
                ]);
            }

            return redirect()->route('legal.legal_documents')->with('success', 'Legal document archived successfully! Disposal date: ' . $document->disposal_date->format('Y-m-d'));
        } catch (\Throwable $e) {
            \Log::error('Error archiving legal document', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error archiving document: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error archiving document: ' . $e->getMessage());
        }
    }

    /**
     * Show legal document
     */
    public function showLegalDocument($id)
    {
        $document = Document::where('source', 'legal_management')->with('uploader')->findOrFail($id);
        return view('legal.show_document', compact('document'));
    }

    /**
     * Download legal document
     */
    public function downloadLegalDocument($id)
    {
        $document = Document::findOrFail($id);

        $filePath = storage_path('app/public/' . $document->file_path);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Approve legal document
     */
    public function approveLegalDocument(Request $request, $id)
    {
        try {
            $document = Document::where('source', 'legal_management')->findOrFail($id);

            $notes = $request->input('notes', '');

            $document->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approval_notes' => $notes,
                'approved_at' => now()
            ]);

            // Log the approval
            AccessLog::create([
                'user_id' => Auth::id() ?? 'unknown',
                'action' => 'legal_document_approved',
                'description' => "Approved legal document: {$document->title}",
                'ip_address' => request()->ip()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document approved successfully!'
                ]);
            }

            return redirect()->route('legal.legal_documents')->with('success', 'Document approved successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error approving document: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error approving document: ' . $e->getMessage());
        }
    }

    /**
     * Decline legal document
     */
    public function declineLegalDocument(Request $request, $id)
    {
        try {
            $document = Document::where('source', 'legal_management')->findOrFail($id);

            $reason = $request->input('reason', '');

            if (empty($reason)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Decline reason is required.'
                    ], 422);
                }
                return back()->with('error', 'Decline reason is required.');
            }

            $document->update([
                'status' => 'declined',
                'declined_by' => Auth::id(),
                'decline_reason' => $reason,
                'declined_at' => now()
            ]);

            // Log the decline (use DeptAccount Dept_no)
            try {
                $deptNo = null;
                $empId = session('emp_id');
                if ($empId) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empId)->first())->Dept_no;
                }
                if (!$deptNo && Auth::check()) {
                    $email = Auth::user()->email ?? '';
                    $empFromEmail = strstr($email, '@', true);
                    if ($empFromEmail) {
                        $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                    }
                }
                AccessLog::create([
                    'user_id' => $deptNo ?? 0,
                    'action' => 'legal_document_declined',
                    'description' => "Declined legal document: {$document->title} - Reason: {$reason}",
                    'ip_address' => request()->ip()
                ]);
            } catch (\Throwable $e) {
                // ignore logging errors
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document declined successfully!'
                ]);
            }

            return redirect()->route('legal.legal_documents')->with('success', 'Document declined successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error declining document: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error declining document: ' . $e->getMessage());
        }
    }

    /**
     * Archive a document
     */
    public function archive($id)
    {
        // Check if user is administrator
        if (!$this->isAdministrator(Auth::user())) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access Denied: Only administrators can archive documents.'
                ], 403);
            }
            return back()->with('error', 'Access Denied: Only administrators can archive documents.');
        }

        try {
            $document = Document::findOrFail($id);
            $document->update(['status' => 'archived']);

            // Log the archive action
            $document->logWorkflowStep('document_archived', 'Document archived by administrator', [
                'archived_by' => Auth::user()->name ?? Auth::user()->id,
                'archived_at' => now()->toISOString()
            ]);

            AccessLog::create([
                'user_id' => Auth::id() ?? 'unknown',
                'action' => 'document_archived',
                'description' => "Document '{$document->title}' archived by administrator",
                'ip_address' => request()->ip()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document archived successfully'
                ]);
            }

            return back()->with('success', 'Document archived successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error archiving document: ' . $e->getMessage()
                ]);
            }

            return back()->with('error', 'Error archiving document: ' . $e->getMessage());
        }
    }

    /**
     * Unarchive a document
     */
    public function unarchive($id)
    {
        try {
            $document = Document::findOrFail($id);
            $document->update(['status' => 'active']);

            // Log the unarchive action
            AccessLog::create([
                'user_id' => Auth::id() ?? 'unknown',
                'action' => 'document_unarchived',
                'description' => "Document '{$document->title}' unarchived",
                'ip_address' => request()->ip()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Document unarchived successfully'
                ]);
            }

            return back()->with('success', 'Document unarchived successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error unarchiving document: ' . $e->getMessage()
                ]);
            }

            return back()->with('error', 'Error unarchiving document: ' . $e->getMessage());
        }
    }

    /**
     * Simulate incoming documents from other departments (Microservices Mock)
     */
    public function simulateIncoming(Request $request)
    {
        try {
            // Check if custom data is provided (from the new modal form)
            if ($request->has('title') && $request->has('category') && $request->has('department')) {
                // Use custom data from form
                $title = $request->input('title');
                $category = $request->input('category');
                $department = $request->input('department');
                $confidentiality = $request->input('confidentiality_level', 'internal');
                $status = $request->input('status', 'archived');
                $retentionPeriod = $request->input('retention_period', '7 Years');

                // Parse retention period to years
                $retentionYears = 7; // default
                if (preg_match('/(\d+)\s*Year/', $retentionPeriod, $matches)) {
                    $retentionYears = (int) $matches[1];
                } elseif ($retentionPeriod === 'Permanent') {
                    $retentionYears = 100; // 100 years for permanent
                }

                $document = Document::create([
                    'title' => $title,
                    'description' => "Imported from External Microservice Integration",
                    'department' => $department,
                    'category' => $category,
                    'status' => $status,
                    'source' => 'external_integration',
                    'uploaded_by' => Auth::id() ?? 1,
                    'file_path' => 'documents/simulated_' . uniqid() . '.pdf',
                    'confidentiality_level' => $confidentiality,
                    'workflow_stage' => $status === 'archived' ? 'archived' : 'active',
                    'archived_at' => $status === 'archived' ? now() : null,
                    'retention_until' => now()->addYears($retentionYears),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Create a lifecycle log
                try {
                    $this->logDocumentLifecycleStep($document, 'imported', [
                        'source_system' => "{$department}_Microservice",
                        'import_method' => 'API Integration (Simulated)'
                    ]);
                } catch (\Exception $e) {
                    \Log::warning('Lifecycle log failed', ['error' => $e->getMessage()]);
                }


                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => "Successfully imported document: {$title}",
                        'document_id' => $document->id
                    ]);
                }

                return back()->with('success', "Successfully imported document: {$title}");
            }

            // Old random generation logic (fallback)
            $departments = ['HR', 'Finance', 'Procurement', 'IT', 'Operations'];
            $docTypes = [
                'HR' => ['Employee Contract', 'Leave Request', 'Performance Review', 'Policy Acknowledgment'],
                'Finance' => ['Invoice #', 'Expense Report', 'Budget Proposal 2026', 'Audit Trail'],
                'Procurement' => ['Purchase Order #', 'Vendor Agreement', 'RFP Response'],
                'IT' => ['Security Audit', 'System Log', 'Access Request'],
                'Operations' => ['Maintenance Log', 'Incident Report', 'Safety Inspection']
            ];

            $count = rand(1, 3); // Simulate 1-3 documents arriving
            $createdDocs = [];

            for ($i = 0; $i < $count; $i++) {
                $dept = $departments[array_rand($departments)];
                $type = $docTypes[$dept][array_rand($docTypes[$dept])];
                $title = $type . (str_contains($type, '#') ? rand(1000, 9999) : ' - ' . uniqid());

                // Determine category based on dept
                $category = match ($dept) {
                    'HR' => 'contract',
                    'Finance' => 'financial',
                    'Procurement' => 'contract',
                    'IT' => 'report',
                    default => 'general'
                };

                $confidentiality = ['internal', 'confidential', 'restricted'][rand(0, 2)];

                $document = Document::create([
                    'title' => $title,
                    'description' => "Auto-imported from {$dept} Department Microservice Integration",
                    'department' => $dept,
                    'category' => $category,
                    'status' => 'archived',
                    'source' => 'external_integration',
                    'uploaded_by' => Auth::id() ?? 1,
                    'file_path' => 'documents/mock_' . uniqid() . '.pdf',
                    'confidentiality_level' => $confidentiality,
                    'workflow_stage' => 'archived',
                    'archived_at' => now(),
                    'retention_until' => now()->addYears(5),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Create a lifecycle log
                $this->logDocumentLifecycleStep($document, 'imported', [
                    'source_system' => "{$dept}_Microservice",
                    'import_method' => 'API Integration (Simulated)'
                ]);

                $createdDocs[] = $document->title;
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully imported " . count($createdDocs) . " documents from external services: " . implode(', ', $createdDocs),
                    'count' => count($createdDocs)
                ]);
            }

            return back()->with('success', "Successfully imported " . count($createdDocs) . " documents from external services.");

        } catch (\Exception $e) {
            \Log::error('Simulation failed', ['error' => $e->getMessage()]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Simulation failed: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Simulation failed.');
        }
    }

    /**
     * Get archived documents with enhanced filtering
     */
    public function archived(Request $request)
    {
        // Include documents that are archived, expired, disposed, or have archived_at set
        // This includes ALL documents regardless of source (legal_management, etc.)
        // Use a simpler, more reliable query structure
        $q = Document::query();
        $q->where(function ($query) {
            $query->where('status', 'archived')
                ->orWhere('status', 'expired')
                ->orWhere('status', 'disposed')
                ->orWhereNotNull('archived_at');
        });

        // Debug: Log the query to see what we're looking for
        $countBeforeFilters = $q->count();
        $sampleIds = $q->limit(5)->pluck('id')->toArray();

        \Log::info('Archived documents query - BEFORE filters', [
            'count_before_filters' => $countBeforeFilters,
            'sample_ids' => $sampleIds,
            'query_sql' => $q->toSql(),
            'query_bindings' => $q->getBindings()
        ]);

        // search
        if ($s = trim($request->string('search'))) {
            $q->where(function ($w) use ($s) {
                $w->where('title', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")
                    ->orWhere('author', 'like', "%{$s}%");
            });
        }

        // filters
        if ($cat = $request->string('category'))
            $q->where('category', $cat);
        if ($auth = $request->string('author'))
            $q->where('author', 'like', "%{$auth}%");
        if ($dept = $request->string('department'))
            $q->where('department', $dept);
        if ($conf = $request->string('confidentiality'))
            $q->where('confidentiality_level', $conf);
        if ($from = $request->date('date_from'))
            $q->whereDate('created_at', '>=', $from);
        if ($to = $request->date('date_to'))
            $q->whereDate('created_at', '<=', $to);

        // sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $dir = $request->input('sort_order', 'desc') === 'asc' ? 'asc' : 'desc';
        $allowed = [
            'created_at',
            'title',
            'author',
            'view_count',
            'download_count',
            'last_edited_at'
        ];
        if (!in_array($sortBy, $allowed))
            $sortBy = 'created_at';
        $q->orderBy($sortBy, $dir);

        // Get totals for stat cards (BEFORE applying search/filters, but AFTER base archived query)
        // This ensures we get the true count of all archived documents
        $baseQuery = Document::query()->where(function ($query) {
            $query->where('status', 'archived')
                ->orWhere('status', 'expired')
                ->orWhere('status', 'disposed')
                ->orWhereNotNull('archived_at');
        });

        $totalCount = $baseQuery->count();

        // Received today should check archived_at, not created_at
        $receivedToday = Document::where(function ($query) {
            $query->where('status', 'archived')
                ->orWhere('status', 'expired')
                ->orWhere('status', 'disposed')
                ->orWhereNotNull('archived_at');
        })
            ->where(function ($query) {
                $query->whereDate('archived_at', '>=', now()->startOfDay())
                    ->orWhere(function ($q) {
                        // Also check if status was changed to archived today
                        $q->where('status', 'archived')
                            ->whereDate('updated_at', '>=', now()->startOfDay());
                    });
            })
            ->count();

        $expiredCount = Document::where('status', 'expired')->count();

        // Log AFTER filters but BEFORE pagination
        $countAfterFilters = $q->count();
        \Log::info('Archived documents query - AFTER filters', [
            'count_after_filters' => $countAfterFilters,
            'search' => $request->string('search'),
            'category' => $request->string('category'),
            'author' => $request->string('author'),
            'department' => $request->string('department'),
            'date_from' => $request->date('date_from'),
            'date_to' => $request->date('date_to'),
            'query_sql' => $q->toSql(),
            'query_bindings' => $q->getBindings()
        ]);

        // If we have documents in the database but filters are hiding them all,
        // clear ALL filters except search (user might be searching)
        if ($totalCount > 0 && $countAfterFilters === 0) {
            // Check if user explicitly set filters (using filled() to check for actual values)
            $hasExplicitFilters = $request->filled('category') || $request->filled('author') ||
                $request->filled('department') || $request->filled('date_from') ||
                $request->filled('date_to') || $request->filled('confidentiality');

            if (!$hasExplicitFilters) {
                // Reset the query without ANY filters (only base archived query + search if exists)
                $q = Document::query()->where(function ($query) {
                    $query->where('status', 'archived')
                        ->orWhere('status', 'expired')
                        ->orWhere('status', 'disposed')
                        ->orWhereNotNull('archived_at');
                });

                // Only apply search if it exists and is meaningful
                if ($s = trim($request->string('search'))) {
                    if (strlen($s) > 2) { // Only if search is more than 2 characters
                        $q->where(function ($w) use ($s) {
                            $w->where('title', 'like', "%{$s}%")
                                ->orWhere('description', 'like', "%{$s}%")
                                ->orWhere('author', 'like', "%{$s}%");
                        });
                    }
                }

                // Re-apply sorting
                $q->orderBy($sortBy, $dir);
                $countAfterFilters = $q->count();

                \Log::info('Auto-cleared ALL filters because documents were hidden', [
                    'total_count' => $totalCount,
                    'count_after_auto_clear' => $countAfterFilters,
                    'had_explicit_filters' => $hasExplicitFilters
                ]);
            }
        }

        // paginate (this applies search and filters)
        $perPage = $request->get('per_page', 10);
        $documents = $q->paginate($perPage)->withQueryString();

        // Debug: Log what we're actually returning
        \Log::info('Archived documents result - FINAL', [
            'total_count' => $totalCount,
            'received_today' => $receivedToday,
            'count_before_filters' => $countBeforeFilters,
            'count_after_filters' => $countAfterFilters,
            'documents_count' => $documents->count(),
            'documents_total' => $documents->total(),
            'current_page' => $documents->currentPage(),
            'last_page' => $documents->lastPage(),
            'has_documents' => $documents->count() > 0,
            'first_item_id' => $documents->count() > 0 ? $documents->first()->id : null,
            'all_document_ids' => $documents->count() > 0 ? $documents->pluck('id')->toArray() : []
        ]);

        return view('document.archived', compact('documents', 'totalCount', 'receivedToday', 'expiredCount'));
    }


    /**
     * Validate extracted text to ensure it's not empty and doesn't contain common OCR errors.
     */
    private function isValidExtractedText($text)
    {
        // Check if text is empty
        if (empty(trim($text))) {
            \Log::warning('DocumentController: Text validation failed - empty text', [
                'text_length' => strlen($text)
            ]);
            return false;
        }

        // Check for common OCR errors and fallback messages
        $lowercaseText = strtolower($text);
        $fallbackIndicators = [
            'unknown document type',
            'document not found',
            'pdf text extraction failed',
            'likely scanned',
            'image file',
            'pdf file',
            'manual review recommended',
            'tmp',
            'file not found'
        ];

        foreach ($fallbackIndicators as $indicator) {
            if (str_contains($lowercaseText, $indicator)) {
                \Log::warning('DocumentController: Text validation failed - contains fallback indicator', [
                    'indicator' => $indicator,
                    'text_preview' => substr($text, 0, 100)
                ]);
                return false;
            }
        }

        // Check if text is too short (likely not meaningful content)
        if (strlen($text) < 50) {
            \Log::warning('DocumentController: Text validation failed - text too short', [
                'text_length' => strlen($text),
                'text_preview' => $text
            ]);
            return false;
        }

        // Check if text contains mostly special characters or numbers
        $alphaContent = preg_replace('/[^a-zA-Z\s]/', '', $text);
        $alphaRatio = strlen($alphaContent) / strlen($text);

        if ($alphaRatio < 0.3) { // Less than 30% alphabetic content
            \Log::warning('DocumentController: Text validation failed - insufficient alphabetic content', [
                'alpha_ratio' => $alphaRatio,
                'text_preview' => substr($text, 0, 100)
            ]);
            return false;
        }

        \Log::info('DocumentController: Text validation passed', [
            'text_length' => strlen($text),
            'alpha_ratio' => $alphaRatio,
            'text_preview' => substr($text, 0, 200)
        ]);

        return true;
    }

    /**
     * Determine a fallback category based on the filename.
     */
    private function determineFallbackCategory($filename)
    {
        $lowercaseFilename = strtolower($filename);

        \Log::info('DocumentController: Determining fallback category from filename', [
            'filename' => $filename,
            'lowercase_filename' => $lowercaseFilename
        ]);

        // Enhanced document type mapping
        $documentTypeMap = [
            // Policy documents
            'privacy' => 'policy',
            'policy' => 'policy',
            'terms' => 'policy',
            'data protection' => 'policy',
            'acceptable use' => 'policy',
            'data privacy' => 'policy',

            // Contract documents
            'contract' => 'contract',
            'agreement' => 'contract',
            'lease' => 'contract',
            'employment' => 'contract',
            'nda' => 'contract',
            'mou' => 'contract',

            // Financial documents
            'invoice' => 'financial',
            'receipt' => 'financial',
            'budget' => 'financial',
            'financial' => 'financial',
            'expense' => 'financial',
            'payment' => 'financial',

            // Legal documents
            'legal' => 'legal',
            'affidavit' => 'legal',
            'subpoena' => 'legal',
            'court' => 'legal',
            'law' => 'legal',
            'litigation' => 'legal',

            // Memorandum documents
            'memo' => 'memorandum',
            'memorandum' => 'memorandum',
            'moa' => 'memorandum',
            'internal' => 'memorandum',
            'staff' => 'memorandum',

            // Report documents
            'report' => 'report',
            'analysis' => 'report',
            'assessment' => 'report',
            'evaluation' => 'report',
            'findings' => 'report',
            'study' => 'report',

            // Compliance documents
            'compliance' => 'compliance',
            'regulation' => 'compliance',
            'regulatory' => 'compliance',
            'audit' => 'compliance',
            'standards' => 'compliance',

            // Communication documents
            'email' => 'communication',
            'letter' => 'communication',
            'correspondence' => 'communication',
            'communication' => 'communication',

            // Presentation documents
            'presentation' => 'presentation',
            'slide' => 'presentation',
            'deck' => 'presentation',

            // Spreadsheet documents
            'spreadsheet' => 'spreadsheet',
            'excel' => 'spreadsheet',
            'sheet' => 'spreadsheet',

            // General documents
            'document' => 'general',
            'doc' => 'general',
            'file' => 'general'
        ];

        // Check for document type indicators
        foreach ($documentTypeMap as $indicator => $category) {
            if (strpos($lowercaseFilename, $indicator) !== false) {
                \Log::info('DocumentController: Fallback category determined from filename', [
                    'filename' => $filename,
                    'indicator' => $indicator,
                    'category' => $category
                ]);
                return $category;
            }
        }

        // Default fallback
        \Log::info('DocumentController: Using default fallback category', [
            'filename' => $filename,
            'default_category' => 'general'
        ]);
        return 'general';
    }

    /**
     * Test OCR extraction for debugging purposes
     */
    public function testOcrExtraction(Request $request)
    {
        try {
            $request->validate([
                'document_file' => 'required|file|max:10240'
            ]);

            $file = $request->file('document_file');

            \Log::info('OCR Test: Starting text extraction test', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                'file_extension' => $file->getClientOriginalExtension()
            ]);

            // Extract text with detailed logging
            $extractedText = $this->textExtractor->extractText($file->getRealPath());

            \Log::info('OCR Test: Text extraction completed', [
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $file->getRealPath(),
                'text_length' => strlen($extractedText),
                'text_preview' => substr($extractedText, 0, 500),
                'is_valid_text' => $this->isValidExtractedText($extractedText),
                'extraction_quality' => $this->assessExtractionQuality($extractedText)
            ]);

            return response()->json([
                'success' => true,
                'file_info' => [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension()
                ],
                'extraction_result' => [
                    'text_length' => strlen($extractedText),
                    'text_preview' => substr($extractedText, 0, 500),
                    'is_valid' => $this->isValidExtractedText($extractedText),
                    'quality_score' => $this->assessExtractionQuality($extractedText),
                    'full_text' => $extractedText
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('OCR Test: Error during text extraction test', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error during OCR test: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Assess the quality of extracted text
     */
    private function assessExtractionQuality($text)
    {
        if (empty($text)) {
            return 'none';
        }

        $length = strlen($text);
        $alphaContent = preg_replace('/[^a-zA-Z\s]/', '', $text);
        $alphaRatio = strlen($alphaContent) / $length;

        // Check for fallback indicators
        $lowercaseText = strtolower($text);
        $fallbackIndicators = [
            'unknown document type',
            'document not found',
            'pdf text extraction failed',
            'likely scanned',
            'image file',
            'pdf file',
            'manual review recommended'
        ];

        foreach ($fallbackIndicators as $indicator) {
            if (str_contains($lowercaseText, $indicator)) {
                return 'fallback';
            }
        }

        // Quality scoring
        if ($length < 50) {
            return 'very_low';
        } elseif ($length < 200) {
            return 'low';
        } elseif ($alphaRatio < 0.3) {
            return 'low';
        } elseif ($length < 1000) {
            return 'medium';
        } elseif ($alphaRatio < 0.5) {
            return 'medium';
        } else {
            return 'high';
        }
    }


    /**
     * Dispose of a document (permanent deletion)
     */
    public function dispose($id)
    {
        // Check if user is administrator
        if (!$this->isAdministrator(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Access Denied: Only administrators can dispose documents.'
            ], 403);
        }

        try {
            $document = Document::findOrFail($id);

            // Only allow disposal of expired documents
            if ($document->status !== 'expired') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only expired documents can be disposed.'
                ], 422);
            }

            // Delete file from storage if present
            if (!empty($document->file_path) && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Log disposal action (use DeptAccount Dept_no)
            try {
                $deptNo = null;
                $empId = session('emp_id');
                if ($empId) {
                    $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empId)->first())->Dept_no;
                }
                if (!$deptNo && Auth::check()) {
                    $email = Auth::user()->email ?? '';
                    $empFromEmail = strstr($email, '@', true);
                    if ($empFromEmail) {
                        $deptNo = optional(\App\Models\DeptAccount::where('employee_id', $empFromEmail)->first())->Dept_no;
                    }
                }
                AccessLog::create([
                    'user_id' => $deptNo ?? 0,
                    'action' => 'document_disposed',
                    'description' => "Document '{$document->title}' permanently disposed",
                    'ip_address' => request()->ip()
                ]);
            } catch (\Throwable $e) {
                // ignore logging errors
            }

            // Log disposal in lifecycle
            $log = $document->lifecycle_log ?? [];
            $log[] = [
                'step' => 'manually_disposed',
                'timestamp' => now()->toISOString(),
                'user_id' => Auth::id(),
                'details' => [
                    'previous_status' => $document->status,
                    'retention_until' => optional($document->retention_until)->toDateTimeString(),
                    'disposed_by' => Auth::id()
                ],
                'ip_address' => request()->ip()
            ];

            // Update document before deletion to log the action
            $document->update(['lifecycle_log' => $log]);

            // Create disposal history record before deleting
            DisposalHistory::create([
                'document_title' => $document->title,
                'document_description' => $document->description,
                'document_category' => $document->category,
                'document_department' => $document->department,
                'document_author' => $document->author,
                'file_path' => $document->file_path,
                'file_name' => basename($document->file_path ?? ''),
                'file_type' => pathinfo($document->file_path ?? '', PATHINFO_EXTENSION),
                'file_size' => $document->file_path ? Storage::disk('public')->size($document->file_path) : null,
                'confidentiality_level' => $document->confidentiality,
                'retention_until' => $document->retention_until,
                'retention_policy' => $document->retention_policy,
                'previous_status' => $document->status,
                'disposal_reason' => 'manually_disposed',
                'disposed_at' => now(),
                'disposed_by' => Auth::id(),
                'lifecycle_log' => $log,
                'ai_analysis' => $document->ai_analysis,
                'metadata' => $document->metadata,
                'ip_address' => request()->ip()
            ]);

            // Permanently delete the document record
            $document->delete();

            return response()->json([
                'success' => true,
                'message' => 'Document disposed successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error disposing document', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error disposing document: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Check if user can access document based on confidentiality level
     */
    private function canAccessDocument($user, Document $document)
    {
        $confidentiality = $document->confidentiality ?? 'internal';
        $userRole = $user->role ?? 'user';

        switch ($confidentiality) {
            case 'public':
                return true;
            case 'internal':
                return true;
            case 'restricted':
                return in_array($userRole, ['admin', 'super_admin', 'legal_admin', 'hr_admin']);
            default:
                return true;
        }
    }

    /**
     * Log document access
     */
    private function logDocumentAccess(Document $document, $user, $action)
    {
        try {
            // Get user ID - be flexible about user types
            $userId = $user->id ?? $user->Dept_no ?? '0';

            // Log to general AccessLog
            AccessLog::create([
                'user_id' => $userId,
                'action' => 'document_' . $action,
                'description' => "Document {$action}: {$document->title} (ID: {$document->id})",
                'document_id' => $document->id,
                'ip_address' => request()->ip(),
                'metadata' => [
                    'document_id' => $document->id,
                    'document_title' => $document->title,
                    'confidentiality' => $document->confidentiality,
                    'user_role' => $user->role ?? 'unknown',
                    'action_type' => $action,
                    'timestamp' => now()->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            // Log error but don't break the main functionality
            \Log::error('Failed to log document access: ' . $e->getMessage());
        }
    }

    /**
     * Check if user is administrator
     */
    private function isAdministrator($user)
    {
        if (!$user) {
            return false;
        }

        $userRole = $user->role ?? 'user';
        return in_array($userRole, ['Admin Manager', 'Owner']);
    }

    /**
     * Export archived documents analytics report
     */
    public function exportArchivedReport(Request $request)
    {
        try {
            $days = $request->input('days', '30');
            $format = $request->input('format', 'excel');

            // Build query for archived documents
            $query = Document::query();
            $query->where(function ($q) {
                $q->where('status', 'archived')
                    ->orWhere('status', 'expired')
                    ->orWhere('status', 'disposed')
                    ->orWhereNotNull('archived_at');
            });

            // Apply date range filter
            if ($days !== 'all') {
                $days = (int) $days;
                $dateThreshold = now()->subDays($days);
                $query->where(function ($q) use ($dateThreshold) {
                    $q->where('archived_at', '>=', $dateThreshold)
                        ->orWhere(function ($subQ) use ($dateThreshold) {
                            $subQ->where('status', 'archived')
                                ->where('updated_at', '>=', $dateThreshold);
                        });
                });
            }

            $documents = $query->orderBy('archived_at', 'desc')->get();

            // Calculate statistics
            $totalArchived = $documents->count();
            $activeDocuments = $documents->where('retention_until', '>', now())->count();
            $expiringSoon = $documents->where('retention_until', '<=', now()->addDays(30))
                ->where('retention_until', '>', now())
                ->count();
            $expired = $documents->where('retention_until', '<=', now())->count();

            // Group by department
            $byDepartment = $documents->groupBy('department')->map(function ($group) {
                return $group->count();
            })->sortDesc();

            // Group by type/category
            $byType = $documents->groupBy('category')->map(function ($group) {
                return $group->count();
            })->sortDesc();

            // Prepare export data
            $exportData = [
                'Overview' => [
                    ['Metric', 'Value'],
                    ['Total Archived Documents', $totalArchived],
                    ['Active Documents (Within Retention)', $activeDocuments],
                    ['Expiring Soon (Next 30 Days)', $expiringSoon],
                    ['Expired Documents', $expired],
                    ['Report Generated', now()->format('Y-m-d H:i:s')],
                    ['Date Range', $days === 'all' ? 'All Time' : "Last {$days} days"],
                ],
                'Documents by Department' => [
                    ['Department', 'Count'],
                    ...$byDepartment->map(function ($count, $dept) {
                        return [$dept ?: 'Unspecified', $count];
                    })->values()->toArray()
                ],
                'Documents by Type' => [
                    ['Type/Category', 'Count'],
                    ...$byType->map(function ($count, $type) {
                        return [$type ?: 'Unspecified', $count];
                    })->values()->toArray()
                ],
                'Document Details' => [
                    ['Title', 'Department', 'Type', 'Confidentiality', 'Archived Date', 'Retention Until', 'Status'],
                    ...$documents->map(function ($doc) {
                        return [
                            $doc->title,
                            $doc->department ?: 'N/A',
                            $doc->category ?: 'N/A',
                            $doc->confidentiality_level ?: $doc->confidentiality ?: 'N/A',
                            $doc->archived_at ? $doc->archived_at->format('Y-m-d') : 'N/A',
                            $doc->retention_until ? $doc->retention_until->format('Y-m-d') : 'N/A',
                            $doc->status
                        ];
                    })->toArray()
                ]
            ];

            if ($format === 'excel') {
                $filename = 'archived_documents_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                return \Maatwebsite\Excel\Facades\Excel::download(
                    new \App\Exports\ArchivedDocumentsReportExport($exportData),
                    $filename
                );
            } else {
                // Default to Excel if format not specified
                $filename = 'archived_documents_report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
                return \Maatwebsite\Excel\Facades\Excel::download(
                    new \App\Exports\ArchivedDocumentsReportExport($exportData),
                    $filename
                );
            }

        } catch (\Exception $e) {
            \Log::error('Error exporting archived documents report: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error generating report: ' . $e->getMessage());
        }
    }
}