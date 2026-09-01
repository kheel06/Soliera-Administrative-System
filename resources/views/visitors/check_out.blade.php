@extends('layouts.app')

@section('title', 'Visitors | Check-Out')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Visitor Check-out</h2>
                <p class="text-sm text-gray-600">Process departures and collect badges.</p>
            </div>
            <div class="flex gap-2">
                <div class="relative">
                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search active visitors..." class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 w-64">
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($activeVisitors->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visitor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Host / Purpose</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge ID</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="visitorTableBody">
                            @foreach($activeVisitors as $visitor)
                            <tr class="hover:bg-gray-50 transition-colors" id="row-{{ $visitor->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold mr-3">
                                            {{ substr($visitor->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 visitor-name">{{ $visitor->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $visitor->company ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $visitor->host_employee ?? $visitor->host_id }}</div>
                                    <div class="text-xs text-gray-500">{{ $visitor->purpose }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($visitor->time_in)->format('h:i A') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($visitor->time_in)->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $visitor->pass_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="checkOut({{ $visitor->id }})" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-md text-sm font-medium transition-colors flex items-center gap-1 ml-auto">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Check Out
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Active Visitors</h3>
                    <p class="text-gray-500 mt-1">There are currently no visitors checked in.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#visitorTableBody tr');
        
        rows.forEach(row => {
            const name = row.querySelector('.visitor-name').textContent.toLowerCase();
            if (name.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function checkOut(id) {
        if(!confirm('Confirm check-out for this visitor?')) return;

        fetch(`/visitor/checkout/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Remove row with animation
                const row = document.getElementById(`row-${id}`);
                row.classList.add('opacity-0', 'transform', 'scale-95');
                setTimeout(() => {
                    row.remove();
                    // Reload if empty to show empty state? Or just let it be.
                    if(document.querySelectorAll('#visitorTableBody tr').length === 0) {
                        location.reload();
                    }
                }, 300);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
</script>
@endsection
