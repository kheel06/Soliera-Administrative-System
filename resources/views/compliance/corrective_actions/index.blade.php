@extends('layouts.app')

@section('title', 'Compliance | Corrective Actions')

@section('content')
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Corrective Actions</h1>
                <p class="text-sm text-gray-500 mt-1">Track and resolve compliance issues and audit findings.</p>
            </div>
            <div class="flex gap-2 mt-4 md:mt-0">
                <button onclick="document.getElementById('createActionModal').showModal()"
                    class="btn btn-primary bg-[#0a1e3b] hover:bg-[#112f5a] text-white border-none gap-2">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    New Action
                </button>
            </div>
        </div>

        <!-- Stats (Standardized Design) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Open Issues -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Open Issues</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['open'] }}</div>
                    <div class="text-xs text-blue-600 mt-1 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i> Pending Resolution
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Critical Priority -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Critical Priority</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['critical'] }}</div>
                    <div class="text-xs text-red-500 mt-1 flex items-center gap-1">
                        <i data-lucide="flame" class="w-3 h-3"></i> Immediate Attention
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="siren" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Resolved (This Month)</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['resolved_month'] }}</div>
                    <div class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <i data-lucide="check-circle" class="w-3 h-3"></i> Completed
                    </div>
                </div>
                <div class="p-3 bg-[#0a1e3b] rounded-lg">
                    <i data-lucide="clipboard-check" class="w-6 h-6 text-[#EDA900]"></i>
                </div>
            </div>
        </div>

        <!-- Action List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">Issue / Task</th>
                            <th class="px-6 py-4 font-bold">Priority</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                            <th class="px-6 py-4 font-bold">Due Date</th>
                            <th class="px-6 py-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($actions as $action)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <div class="font-bold text-gray-800">{{ $action->title }}</div>
                                                    <div class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $action->description }}</div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $priorityColors = [
                                                            'Low' => 'bg-gray-100 text-gray-600',
                                                            'Medium' => 'bg-blue-100 text-blue-600',
                                                            'High' => 'bg-orange-100 text-orange-600',
                                                            'Critical' => 'bg-red-100 text-red-600'
                                                        ];
                                                    @endphp
                             <span
                                                        class="px-2 py-1 rounded text-xs font-bold uppercase {{ $priorityColors[$action->priority] ?? 'bg-gray-100 text-gray-600' }}">
                                                        {{ $action->priority }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="flex items-center gap-2 text-sm font-medium text-gray-700">
                                                        <span class="w-2 h-2 rounded-full 
                                                                    {{ $action->status === 'Open' ? 'bg-blue-500' :
                                ($action->status === 'Resolved' ? 'bg-green-500' : 'bg-gray-300') }}">
                                                        </span>
                                                        {{ $action->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    @if($action->due_date)
                                                        <div class="flex items-center gap-1.5">
                                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-gray-400"></i>
                                                            {{ $action->due_date->format('M d, Y') }}
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 italic">No valid date</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <button class="btn btn-ghost btn-xs">Edit</button>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <i data-lucide="check-circle" class="w-12 h-12 mx-auto mb-3 opacity-20"></i>
                                    <p>No corrective actions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($actions->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $actions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Modal -->
    <dialog id="createActionModal" class="modal">
        <div class="modal-box bg-white rounded-2xl p-0 overflow-hidden max-w-lg">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">New Corrective Action</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-gray-500">✕</button>
                </form>
            </div>

            <form action="{{ route('compliance.corrective_actions.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Issue Title</label>
                    <input type="text" name="title" required
                        class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]"
                        placeholder="e.g. Update Fire Safety Protocols">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority"
                            class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]">
                            <option>Low</option>
                            <option selected>Medium</option>
                            <option>High</option>
                            <option>Critical</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                        <input type="date" name="due_date"
                            class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-[#0a1e3b] focus:ring-[#0a1e3b]"
                        placeholder="Describe the issue and required action..."></textarea>
                </div>

                <div class="pt-4 flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('createActionModal').close()"
                        class="btn btn-ghost hover:bg-gray-100">Cancel</button>
                    <button type="submit"
                        class="btn btn-primary bg-[#0a1e3b] hover:bg-[#112f5a] text-white border-none">Create
                        Action</button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection