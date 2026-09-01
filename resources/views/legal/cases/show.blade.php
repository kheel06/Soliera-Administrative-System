@extends('layouts.app')

@section('title', $case->case_title)

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center" x-data="{ openUpdate: false, openUpload: false }">
                <div>
                    <a href="{{ route('legal.cases.desk', ['tab' => 'all']) }}"
                        class="text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Cases
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $case->case_title }}</h2>
                    <p class="text-gray-600">Case #{{ $case->case_number }} • <span
                            class="{{ $case->status_color }} px-2 py-0.5 rounded-full text-xs font-medium">{{ $case->status_label }}</span>
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('legal.cases.desk.edit', $case->id) }}"
                        class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 font-medium">Edit</a>
                    <button @click="openUpdate = true"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">Add
                        Update</button>
                </div>

                <!-- Add Update Modal -->
            <div x-show="openUpdate" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" style="display: none;">
                <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6" @click.away="openUpdate = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Add Case Update</h3>
                        <button @click="openUpdate = false" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                    </div>
                    <form action="{{ route('legal.cases.desk.add-update', $case->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Description</label>
                            <textarea name="description" rows="3" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="What happened?"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes (Optional)</label>
                            <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Any private notes..."></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="openUpdate = false" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Save Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Upload Document Modal -->
            <div x-show="openUpload" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" style="display: none;">
                <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6" @click.away="openUpload = false">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">Upload Case Document</h3>
                        <button @click="openUpload = false" class="text-gray-400 hover:text-gray-600"><i data-lucide="x" class="w-5 h-5"></i></button>
                    </div>
                    <form action="{{ route('legal.cases.desk.upload-document', $case->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Title</label>
                            <input type="text" name="title" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., Police Report, Witness Statement">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                            <input type="file" name="file" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end gap-3 border-t pt-4 mt-4">
                            <button type="button" @click="openUpload = false" class="px-4 py-2 border rounded-md text-gray-600 hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Details Card -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="info" class="w-5 h-5 text-blue-500"></i>
                            Case Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Type</span>
                                <span class="block text-gray-900 font-medium mt-1">{{ ucfirst($case->case_type) }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Priority</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $case->priority_color }} mt-1">
                                    {{ ucfirst($case->priority) }}
                                </span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Filing Date</span>
                                <span class="block text-gray-900 font-medium mt-1">{{ $case->filing_date ? $case->filing_date->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Court Date</span>
                                <span class="block text-gray-900 font-medium mt-1">{{ $case->court_date ? $case->court_date->format('M d, Y') : 'TBD' }}</span>
                            </div>
                        </div>
                        <div class="mt-6">
                            <span class="block text-sm font-medium text-gray-500 uppercase tracking-wider">Description</span>
                            <div class="mt-2 text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                {{ $case->case_description }}
                            </div>
                        </div>
                    </div>

                    <!-- Timeline/Activities (Placeholder) -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <i data-lucide="history" class="w-5 h-5 text-blue-500"></i>
                            Activity Timeline
                        </h3>
                        <div class="border-l-2 border-blue-100 ml-4 space-y-8 relative">
                            @forelse($case->activities as $activity)
                            <div class="relative pl-8">
                                <div class="absolute -left-2.5 top-0 w-5 h-5 rounded-full bg-white border-4 border-blue-500 shadow-sm"></div>
                                <div class="flex justify-between items-start mb-1">
                                    <div class="text-sm font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $activity->action_type)) }}</div>
                                    <div class="text-[10px] text-gray-400 font-medium uppercase">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $activity->action_description }}</p>
                                @if(isset($activity->changes['notes']) && $activity->changes['notes'])
                                <div class="mt-2 text-xs bg-gray-50 p-3 rounded-md border-l-2 border-gray-300 italic text-gray-600">
                                    "{{ $activity->changes['notes'] }}"
                                </div>
                                @endif
                                <div class="mt-2 text-[10px] text-gray-400 flex items-center gap-1">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    Logged by {{ $activity->user_name }} • {{ $activity->created_at->format('M d, Y @ h:i A') }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-6">
                                <div class="bg-gray-50 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                                    <i data-lucide="calendar" class="w-6 h-6 text-gray-400"></i>
                                </div>
                                <p class="text-gray-500">No activity recorded for this case yet.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- People -->
                    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i data-lucide="users" class="w-5 h-5 text-blue-500"></i>
                            Responsible Parties
                        </h3>
                        <div class="space-y-4">
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Assigned Investigator</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-sm">
                                        {{ substr($case->assignedTo->employee_name ?? 'U', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $case->assignedTo->employee_name ?? 'Unassigned' }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $case->assignedTo->dept_name ?? 'Legal Department' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Creating Officer</span>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-sm font-bold text-white shadow-sm">
                                        {{ substr($case->createdBy->employee_name ?? 'S', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $case->createdBy->employee_name ?? 'System' }}</div>
                                        <div class="text-[10px] text-gray-500">Registered on {{ $case->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i data-lucide="folder" class="w-5 h-5 text-blue-500"></i>
                                Case Evidence
                            </h3>
                            <span class="text-xs font-bold bg-blue-100 text-blue-600 px-2 py-1 rounded-full">{{ $case->documents->count() }}</span>
                        </div>
                        <ul class="space-y-3">
                            @forelse($case->documents as $doc)
                            <li class="group flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-blue-50 rounded text-blue-600">
                                        <i data-lucide="file-text" class="w-4 h-4"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 truncate max-w-[150px]">{{ $doc->title }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $doc->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                            </li>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-xs text-gray-500">No documents attached yet.</p>
                            </div>
                            @endforelse
                        </ul>
                        <button @click="openUpload = true" class="w-full mt-6 border-2 border-dashed border-gray-200 rounded-xl p-3 text-sm text-gray-500 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all flex items-center justify-center gap-2 group font-medium">
                            <i data-lucide="upload-cloud" class="w-5 h-5 group-hover:animate-bounce"></i>
                            Attach New Evidence
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection