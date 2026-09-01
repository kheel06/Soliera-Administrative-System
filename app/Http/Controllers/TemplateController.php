<?php

namespace App\Http\Controllers;

use App\Models\LegalTemplate;
use App\Models\LegalClause;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = LegalTemplate::all();
        $clauses = LegalClause::all();
        return view('legal.templates.index', compact('templates', 'clauses'));
    }

    public function create()
    {
        return view('legal.templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:legal_templates',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'version' => 'nullable|string',
            'status' => 'required|string',
            'tags' => 'nullable|array',
        ]);

        $template = LegalTemplate::create($validated);
        $template->created_by = auth()->id();
        $template->save();

        \App\Services\SystemNotificationService::notifyTemplateAction('created', $template);

        return redirect()->route('legal.templates')->with('success', 'Template created successfully.');
    }
}
