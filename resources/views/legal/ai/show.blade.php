@extends('layouts.app')

@section('title', 'AI Analysis Report')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $result->ai_result['title'] ?? 'Document Analysis Report' }}
                        </h2>
                        <span class="{{ $result->risk_level_color }} text-sm font-bold px-3 py-1 rounded-full">
                            {{ ucfirst($result->risk_level) }} Risk
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Analysis performed on
                        {{ $result->created_at->format('M d, Y H:i A') }}
                    </p>
                </div>
                <a href="{{ route('legal.ai.insights') }}"
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Findings -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Summary Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-5 h-5 text-gray-500"></i>
                            Executive Summary
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $result->summary }}</p>
                    </div>

                    <!-- Violations Detected -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-gray-500"></i>
                            Key Issues & Violations
                        </h3>
                        @if(count($result->detected_violations) > 0)
                            <div class="space-y-4">
                                @foreach($result->detected_violations as $violation)
                                    @php
                                        $isArr = is_array($violation);
                                        $sev = $isArr ? ($violation['severity'] ?? 'Medium') : 'Medium';
                                        $issue = $isArr ? ($violation['issue'] ?? 'Unknown Issue') : $violation;
                                        $evidence = $isArr ? ($violation['clause_text'] ?? 'Not specified') : 'Original extraction';

                                        $isHigh = in_array($sev, ['Critical', 'High']);
                                        $borderClass = $isHigh ? 'border-red-500 bg-red-50' : 'border-yellow-500 bg-yellow-50';
                                        $textClass = $isHigh ? 'text-red-800' : 'text-yellow-800';
                                    @endphp
                                    <div class="border-l-4 {{ $borderClass }} p-4 rounded-r-lg">
                                        <div class="flex justify-between items-start">
                                            <h4 class="font-bold {{ $textClass }}">
                                                {{ $issue }}
                                            </h4>
                                            <span class="text-xs font-bold uppercase tracking-wide {{ $textClass }}">
                                                {{ $sev }} Priority
                                            </span>
                                        </div>
                                        <p class="text-sm mt-2 text-gray-700"><strong>Clause:</strong>
                                            "{{ $evidence }}"</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div
                                class="flex flex-col items-center justify-center py-8 text-center bg-green-50 rounded-lg border border-green-100">
                                <div class="p-3 bg-green-100 rounded-full mb-3">
                                    <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                                </div>
                                <h4 class="font-semibold text-green-800">No Critical Issues Found</h4>
                                <p class="text-sm text-green-600">This document appears to be compliant with standard policies.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Score Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <div
                            class="inline-flex items-center justify-center w-24 h-24 rounded-full border-4 {{ $result->risk_level == 'low' ? 'border-green-500 text-green-600' : ($result->risk_level == 'medium' ? 'border-yellow-500 text-yellow-600' : 'border-red-500 text-red-600') }} mb-4">
                            <div class="flex flex-col items-center justify-center -space-y-1">
                                <span class="text-xl font-bold">{{ number_format($result->confidence, 1) }}%</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Confidence Score</p>
                    </div>

                    <!-- Recommendations -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-500"></i>
                            Recommendations
                        </h3>
                        <ul class="space-y-3">
                            @foreach($result->recommendations as $rec)
                                <li class="flex items-start gap-3">
                                    <i data-lucide="arrow-right-circle" class="w-4 h-4 text-blue-500 mt-1 shrink-0"></i>
                                    <span class="text-sm text-gray-600">{{ $rec }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection