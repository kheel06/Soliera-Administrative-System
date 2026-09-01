<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Document;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        // This could be the root view
        return redirect()->route('vault.documents.index_new');
    }

    public function show(Request $request, $id)
    {
        $folder = Folder::with(['parent', 'children', 'documents.uploader'])->findOrFail($id);

        // Breadcrumbs logic
        $breadcrumbs = [];
        $current = $folder->parent; // Start from parent
        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent;
        }

        // Search logic for subfolders
        $subfoldersQuery = $folder->children();
        if ($search = $request->input('search')) {
            $subfoldersQuery->where('name', 'like', "%{$search}%");
        }
        // Filter subfolders by department if specified (assuming folders have department)
        if ($department = $request->input('department')) {
            $subfoldersQuery->where('department', $department);
        }
        // Filter subfolders by category if specified
        if ($category = $request->input('category')) {
            $subfoldersQuery->where('category', $category);
        }
        // Search by tags (JSON)
        if ($search = $request->input('search')) {
            $subfoldersQuery->orWhereJsonContains('tags', $search);
        }

        $subfolders = $subfoldersQuery->get();

        // Search logic for documents
        $documentsQuery = $folder->documents();

        // Search
        if ($search = $request->input('search')) {
            $documentsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereJsonContains('tags', $search);
            });
        }

        // Filters
        if ($category = $request->input('category')) {
            $documentsQuery->where('category', $category);
        }
        if ($department = $request->input('department')) {
            $documentsQuery->where('department', $department);
        }
        if ($dateFrom = $request->input('date_from')) {
            $documentsQuery->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->input('date_to')) {
            $documentsQuery->whereDate('created_at', '<=', $dateTo);
        }

        $documents = $documentsQuery->latest()->paginate(20)->withQueryString();

        // Storage Dynamic Calculation (Estimated 15MB per doc)
        $avgSize = 15;
        $totalDocs = \App\Models\Document::count();

        $archivedDocs = \App\Models\Document::where('status', 'archived')->count();

        $activeContracts = \App\Models\Document::where('status', '!=', 'archived')
            ->where('category', 'contract')
            ->count();

        $activeMedia = \App\Models\Document::where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->where('file_path', 'like', '%.jpg')
                    ->orWhere('file_path', 'like', '%.png')
                    ->orWhere('file_path', 'like', '%.jpeg')
                    ->orWhere('file_path', 'like', '%.mp4');
            })->count();

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

        return view('vault.documents.index', [
            'currentFolder' => $folder,
            'folders' => $subfolders,
            'documents' => $documents,
            'breadcrumbs' => $breadcrumbs,
            'stats' => $stats
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
            'department' => 'nullable|string',
            'category' => 'nullable|string',
            'tags' => 'nullable|string'
        ]);

        $tags = $request->tags ? array_map('trim', explode(',', $request->tags)) : null;

        $folder = Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'user_id' => auth()->id(),
            'department' => $request->department,
            'category' => $request->category,
            'tags' => $tags,
            'description' => $request->description
        ]);

        // Notify stakeholders
        \App\Services\SystemNotificationService::notifyFolderAction('created', $folder);

        if ($request->parent_id) {
            return redirect()->route('vault.folders.show', $request->parent_id)->with('success', 'Folder created successfully.');
        }

        return redirect()->route('vault.documents.index_new')->with('success', 'Folder created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string',
            'category' => 'nullable|string'
        ]);

        $folder = Folder::findOrFail($id);
        $oldName = $folder->name;

        $folder->update([
            'name' => $request->name,
            'department' => $request->department ?? $folder->department,
            'category' => $request->category ?? $folder->category,
            'description' => $request->description ?? $folder->description
        ]);

        // Log folder update
        try {
            AccessLog::create([
                'user_id' => auth()->id(),
                'action' => 'folder_updated',
                'description' => "Folder renamed from '{$oldName}' to '{$folder->name}'.",
                'ip_address' => request()->ip(),
                'metadata' => ['folder_id' => $folder->id]
            ]);
        } catch (\Exception $e) {
        }

        return redirect()->back()->with('success', 'Folder updated successfully.');
    }

    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        $parentId = $folder->parent_id;

        // Log folder deletion
        try {
            AccessLog::create([
                'user_id' => auth()->id(),
                'action' => 'folder_deleted',
                'description' => "Folder '{$folder->name}' deleted.",
                'ip_address' => request()->ip(),
                'metadata' => ['folder_id' => $folder->id]
            ]);
        } catch (\Exception $e) {
            \Log::warning('Failed to log folder deletion: ' . $e->getMessage());
        }

        // Delete folder (cascade will handle children if configured, but let's be safe)
        // Note: Migration has onDelete('cascade') for parent_id, so subfolders go.
        // Documents have onDelete('set null'), so they will be orphaned (moved to root).

        // Notify stakeholders BEFORE deletion so we have the object data
        \App\Services\SystemNotificationService::notifyFolderAction('deleted', $folder);

        $folder->delete();

        if ($parentId) {
            return redirect()->route('vault.folders.show', $parentId)->with('success', 'Folder deleted.');
        }

        return redirect()->route('vault.documents.index_new')->with('success', 'Folder deleted.');
    }
}
