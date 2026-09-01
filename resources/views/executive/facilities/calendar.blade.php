@extends('layouts.app')

@section('title', 'Executive | Facilities Calendar')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Facilities Resource Calendar</h1>
                <p class="text-sm text-gray-600">Overview of facility usage and upcoming schedules.</p>
            </div>
            <div class="text-sm text-gray-500">
                Today: {{ now()->format('M d, Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Bookings Today Card -->
            <div
                class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wide">Total Bookings Today</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-800">{{ $bookingsToday }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>

            <!-- Utilization Rate Card -->
            <div
                class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wide">Utilization Rate</h3>
                    <p class="text-3xl font-bold mt-2 text-gray-800">{{ $utilizationRate }}%</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                    <i data-lucide="bar-chart-2" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div id="calendar" class="min-h-[700px] font-sans"></div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                themeSystem: 'standard',
                height: 'auto', // Adjust height to content
                navLinks: true, // can click day/week names to navigate views
                businessHours: true, // display business hours
                dayMaxEvents: true, // allow "more" link when too many events
                events: @json($calendarEvents),
                eventClick: function (info) {
                    // You could use a modal here for better UX
                    alert(
                        'Event: ' + info.event.title + '\n' +
                        'Reserved by: ' + info.event.extendedProps.reserver + '\n' +
                        'Status: ' + info.event.extendedProps.status + '\n' +
                        'Time: ' + info.event.start.toLocaleTimeString() + ' - ' + (info.event.end ? info.event.end.toLocaleTimeString() : 'N/A')
                    );
                },
                eventDidMount: function (info) {
                    // Optional: Add tooltips or styling based on status
                    // const status = info.event.extendedProps.status;
                }
            });
            calendar.render();
        });
    </script>

    <style>
        /* Custom FullCalendar Overrides for Soliera Theme */
        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 700;
            color: #1f2937;
        }

        .fc-button-primary {
            background-color: #001F54 !important;
            border-color: #001F54 !important;
        }

        .fc-button-primary:hover {
            background-color: #00153a !important;
            border-color: #00153a !important;
        }

        .fc-button-active {
            background-color: #F7B32B !important;
            border-color: #F7B32B !important;
            color: #000 !important;
        }

        .fc-daygrid-event {
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 0.85em;
        }
    </style>
@endsection