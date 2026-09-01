@extends('layouts.app')

@section('title', 'AI Legal Assistant')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">AI Legal Assistant</h2>
                    <p class="text-sm text-gray-600">Automated contract analysis and risk detection.</p>
                </div>
                <a href="{{ route('legal.ai.create') }}"
                    class="bg-[#EDA900] hover:bg-[#d49700] text-[#0A1829] font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-colors duration-200">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    Analyze New Document
                </a>
            </div>

            <!-- AI Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-purple-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <i data-lucide="file-search" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-xs font-medium bg-white/20 px-2 py-1 rounded-full">+12% this week</span>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ $totalAnalyzed }}</div>
                    <div class="text-sm text-purple-100">Documents Analyzed</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-[#0A1829] rounded-lg">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-[#EDA900]"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Risk Detection</h3>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ $highRiskCount }}</div>
                    <div class="text-sm text-gray-500">High risk clauses flagged requiring review.</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-[#0A1829] rounded-lg">
                            <i data-lucide="clock" class="w-5 h-5 text-[#EDA900]"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Time Saved</h3>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">~{{ $timeSavedHours }} hrs</div>
                    <div class="text-sm text-gray-500">Estimated manual review time saved.</div>
                </div>
            </div>

            <!-- Recent Analysis Grid -->
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Analyses</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($recentAnalyses as $analysis)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-start">
                        <div class="flex gap-4">
                            <div class="p-3 bg-[#0A1829] rounded-xl">
                                @if($analysis->risk_level == 'high' || $analysis->risk_level == 'critical')
                                    <i data-lucide="file-warning" class="w-6 h-6 text-[#EDA900]"></i>
                                @elseif($analysis->risk_level == 'low')
                                    <i data-lucide="file-check" class="w-6 h-6 text-[#EDA900]"></i>
                                @else
                                    <i data-lucide="file-question" class="w-6 h-6 text-[#EDA900]"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $analysis->ai_result['title'] ?? 'Document Analysis' }}</h4>
                                <p class="text-sm text-gray-500">
                                    Uploaded {{ $analysis->created_at->diffForHumans() }} 
                                    @if(isset($analysis->ai_result['uploader'])) by {{ $analysis->ai_result['uploader'] }} @endif
                                </p>
                            </div>
                        </div>
                        <span class="{{ $analysis->risk_level_color }} text-xs font-bold px-2 py-1 rounded-full">
                            {{ ucfirst($analysis->risk_level) }} Risk
                        </span>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <h5 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Key Findings</h5>
                        <ul class="space-y-3">
                            @if(count($analysis->detected_violations) > 0)
                                @foreach(array_slice($analysis->detected_violations, 0, 3) as $violation)
                                    @php
                                        $isArr = is_array($violation);
                                        $sev = $isArr ? ($violation['severity'] ?? 'Medium') : 'Medium';
                                        $issue = $isArr ? ($violation['issue'] ?? 'Unknown Issue') : $violation;
                                        $icon = ($sev == 'Critical' || $sev == 'High') ? 'x-circle' : 'alert-circle';
                                        $color = ($sev == 'Critical' || $sev == 'High') ? 'text-red-500' : 'text-yellow-500';
                                    @endphp
                                    <li class="flex items-start gap-2 text-sm text-gray-700">
                                        <i data-lucide="{{ $icon }}" class="w-4 h-4 {{ $color }} mt-0.5 shrink-0"></i>
                                        <span>{{ $issue }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="flex items-start gap-2 text-sm text-gray-700">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-green-500 mt-0.5 shrink-0"></i>
                                    <span>No major violations detected.</span>
                                </li>
                            @endif
                        </ul>
                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-end">
                            <a href="{{ route('legal.ai.show', $analysis->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                View Full Report <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection