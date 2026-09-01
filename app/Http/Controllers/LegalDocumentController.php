<?php

namespace App\Http\Controllers;

use App\Models\LegalDocument;
use App\Services\PDFCensorshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class LegalDocumentController extends Controller
{
    protected $censorshipService;
    
    public function __construct(PDFCensorshipService $censorshipService)
    {
        $this->censorshipService = $censorshipService;
    }
    
    public function index()
    {
        $documents = LegalDocument::with(['creator', 'uploader'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('legal.documents.index', compact('documents'));
    }

    public function show($id)
    {
        $document = LegalDocument::with(['creator', 'uploader', 'case'])
            ->findOrFail($id);
            
        return view('legal.documents.show', compact('document'));
    }

    public function preview($id)
    {
        $document = LegalDocument::findOrFail($id);
        
        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'Document file not found');
        }

        // Get censored version for preview
        $censoredPath = $this->censorshipService->getCensoredPdfPath($document);
        
        if (!$censoredPath || !Storage::disk('public')->exists($censoredPath)) {
            abort(404, 'Censored document not available');
        }

        $filePath = Storage::disk('public')->path($censoredPath);
        
        // Add headers to prevent caching and ensure privacy
        return Response::file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->title . '.pdf"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff'
        ]);
    }

    public function download($id)
    {
        $document = LegalDocument::findOrFail($id);
        
        if (!$document->file_path || !Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'Document file not found');
        }

        // For downloads, we provide the original (uncensored) document
        // but with proper access logging
        \Log::info('Legal document downloaded', [
            'document_id' => $document->id,
            'document_title' => $document->title,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()->email ?? 'guest',
            'ip_address' => request()->ip(),
            'timestamp' => now()
        ]);

        return Storage::disk('public')->download($document->file_path, $document->title . '.pdf');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $documents = LegalDocument::with(['creator', 'uploader'])
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('department', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('legal.documents.index', compact('documents', 'query'));
    }
}
