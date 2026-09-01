@extends('layouts.app')

@section('title', 'Facilities | Reservations')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Resource Booking Desk</h2>
                <p class="text-sm text-gray-600">Manage facility reservations, approvals, and usage.</p>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                New Reservation
            </button>
        </div>

        <!-- Metrics/KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-blue-500">
                <div class="text-sm text-gray-500">Today's Bookings</div>
                <div class="text-2xl font-bold">12</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-yellow-500">
                <div class="text-sm text-gray-500">Pending Approvals</div>
                <div class="text-2xl font-bold">5</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-green-500">
                <div class="text-sm text-gray-500">Active Now</div>
                <div class="text-2xl font-bold">4</div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-gray-500">
                <div class="text-sm text-gray-500">Maintenance Mode</div>
                <div class="text-2xl font-bold">1</div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-4">
            <div class="flex flex-col md:flex-row gap-4 justify-between">
                <div class="flex gap-2">
                    <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">Upcoming</button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Past</button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Calendar View</button>
                </div>
                <div class="flex gap-2">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" placeholder="Search reservations..." class="pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button class="px-3 py-2 border rounded-lg hover:bg-gray-50"><i data-lucide="filter" class="w-4 h-4"></i></button>
                </div>
            </div>
        </div>

        <!-- Reservations Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facility / Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sample Row 1 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Conference Room A</div>
                                <div class="text-xs text-gray-500">Capacity: 20</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold mr-2">JS</div>
                                    <div>
                                        <div class="font-medium text-gray-900">John Smith</div>
                                        <div class="text-xs text-gray-500">Sales Dept</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>Jan 28, 2026</div>
                                <div class="text-xs text-gray-500">09:00 AM - 11:00 AM</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmed</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Internal</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-400 hover:text-gray-600"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                        <!-- Sample Row 2 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Grand Ballroom</div>
                                <div class="text-xs text-gray-500">Capacity: 200</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-2">EX</div>
                                    <div>
                                        <div class="font-medium text-gray-900">External Client</div>
                                        <div class="text-xs text-gray-500">Event Corp</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>Feb 02, 2026</div>
                                <div class="text-xs text-gray-500">08:00 AM - 05:00 PM</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Approval</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unpaid</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">Review</button>
                                <button class="text-gray-400 hover:text-gray-600"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                        <!-- Sample Row 3 -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Training Room 1</div>
                                <div class="text-xs text-gray-500">Capacity: 15</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold mr-2">HR</div>
                                    <div>
                                        <div class="font-medium text-gray-900">HR Department</div>
                                        <div class="text-xs text-gray-500">Training</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>Jan 28, 2026</div>
                                <div class="text-xs text-gray-500">02:00 PM - 04:00 PM</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Progress</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Internal</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-400 hover:text-gray-600"><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">24</span> results
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Previous</a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                                <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Next</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
