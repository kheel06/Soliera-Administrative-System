@extends('layouts.app')

@section('title', 'Compliance | AI Insights')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">AI Policy Analysis</h1>
                <p class="text-sm text-gray-500 mt-1">Automated risk assessment and compliance scoring powered by Gemini.
                </p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <button class="btn btn-outline gap-2 text-[#0a1e3b] hover:bg-[#0a1e3b] hover:text-white">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Refresh Analysis
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Avg Score -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Avg Compliance Score
                    </div>
                    <div class="text-3xl font-bold text-gray-900">{{ round($complianceScore ?? 0) }}%</div>
                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                        <i data-lucide="file-check" class="w-3 h-3"></i> Across {{ $analyzedDocs->count() }} docs
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="shield-check" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Risk Alerts -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">High Risk Detected</div>
                    <div class="text-3xl font-bold text-red-600">{{ $highRiskCount }}</div>
                    <div class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> Require Review
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="siren" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- AI Usage -->
            <div
                class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Analysis Coverage</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $analyzedDocs->count() }}</div>
                    <div class="text-xs text-blue-600 mt-1 flex items-center gap-1">
                        <i data-lucide="stars" class="w-3 h-3"></i> Processed by Gemini
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="brain-circuit" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>
        </div>

        <!-- Insights Grid -->
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="sparkles" class="w-5 h-5 text-purple-600"></i>
            Recent Analysis
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($recentInsights as $doc)
                @php
                    $analysis = $doc->ai_analysis;
                    $riskScore = $analysis['risk_score'] ?? 0;
                    $riskColor = $riskScore > 70 ? 'text-red-600' : ($riskScore > 30 ? 'text-amber-600' : 'text-green-600');
                    $riskBg = $riskScore > 70 ? 'bg-red-50' : ($riskScore > 30 ? 'bg-amber-50' : 'bg-green-50');
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 line-clamp-1">{{ $doc->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $doc->created_at->format('M d, Y • h:i A') }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $riskBg }} {{ $riskColor }}">
                            Risk: {{ $riskScore }}/100
                        </span>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Executive Summary</h5>
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                            {{ $analysis['summary'] ?? 'No summary available.' }}
                        </p>
                    </div>

                    @if(!empty($analysis['key_risks']))
                        <div class="mb-4">
                            <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Identified Risks</h5>
                            <ul class="space-y-1">
                                @foreach(array_slice($analysis['key_risks'], 0, 2) as $risk)
                                    <li class="text-xs text-red-600 flex items-start gap-1.5">
                                        <i data-lucide="x-circle" class="w-3.5 h-3.5 mt-0.5 flex-shrink-0"></i>
                                        <span>{{ $risk }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-gray-50 flex justify-end">
                        <button
                            class="text-xs font-bold text-[#0a1e3b] hover:text-blue-600 uppercase tracking-wider flex items-center gap-1">
                            View Full Report <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="bot" class="w-8 h-8 text-blue-500"></i>
                    </div>
                    <h3 class="text-gray-900 font-bold">No Analysis Data Yet</h3>
                    <p class="text-gray-500 text-sm mt-1 max-w-sm mx-auto">
                        Upload compliance documents to the Evidence module to see AI-generated insights here.
                    </p>
                    <a href="{{ route('compliance.evidence') }}" class="btn btn-sm btn-primary mt-4 bg-[#0a1e3b] text-white">
                        Go to Evidence
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection