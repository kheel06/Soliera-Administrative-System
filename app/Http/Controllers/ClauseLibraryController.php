<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LegalClause;
use Illuminate\Http\Request;

class ClauseLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = LegalClause::query();

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('content', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by Mandatory
        if ($request->filled('mandatory')) {
            if ($request->mandatory === 'yes') {
                $query->where('is_mandatory', true);
            }
        }

        $clauses = $query->latest()->get();
        return view('legal.clauses.index', compact('clauses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
        ]);

        LegalClause::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'is_mandatory' => $request->has('is_mandatory'),
            'tags' => $request->tags ? json_encode(array_map('trim', explode(',', $request->tags))) : null
        ]);

        return redirect()->route('legal.clauses')->with('success', 'New legal clause added successfully.');
    }
}
