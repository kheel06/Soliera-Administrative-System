<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiComplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch compliance documents that have been analyzed
        $analyzedDocs = \App\Models\Document::where('category', 'compliance')
            ->whereNotNull('ai_analysis')
            ->latest()
            ->get();

        // Calculate Stats
        $highRiskCount = $analyzedDocs->filter(function ($doc) {
            return ($doc->ai_analysis['risk_score'] ?? 0) > 70;
        })->count();

        $complianceScore = $analyzedDocs->avg(function ($doc) {
            return $doc->ai_analysis['compliance_score'] ?? 0;
        });

        // Recent Insights
        $recentInsights = $analyzedDocs->take(5);

        return view('compliance.ai.insights', compact('analyzedDocs', 'highRiskCount', 'complianceScore', 'recentInsights'));
    }
}
