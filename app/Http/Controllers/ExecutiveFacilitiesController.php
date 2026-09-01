<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExecutiveFacilitiesController extends Controller
{
    public function calendar()
    {
        // 1. Total Bookings Today
        $today = \Carbon\Carbon::today();
        $bookingsToday = \App\Models\FacilityReservation::whereDate('start_time', $today)->count();

        // 2. Utilization Rate (Today)
        // Assume 9 hours per facility per day availability (8 AM - 5 PM)
        $totalFacilities = \App\Models\Facility::count();
        $availableHours = $totalFacilities * 9;

        $reservationsToday = \App\Models\FacilityReservation::whereDate('start_time', $today)
            ->whereIn('status', ['approved', 'completed', 'active'])
            ->get();

        $bookedHours = 0;
        foreach ($reservationsToday as $res) {
            $start = \Carbon\Carbon::parse($res->start_time);
            $end = \Carbon\Carbon::parse($res->end_time);
            $bookedHours += $end->diffInHours($start);
        }

        $utilizationRate = $availableHours > 0 ? round(($bookedHours / $availableHours) * 100, 1) : 0;

        // 3. Calendar Events (Current Month & Future)
        $events = \App\Models\FacilityReservation::with('facility', 'reserver')
            ->get(); // Get all for calendar navigation

        $calendarEvents = $events->map(function ($event) {
            $statusColor = match ($event->status) {
                'approved' => '#10B981', // green
                'pending' => '#F59E0B', // yellow
                'denied' => '#EF4444', // red
                'completed' => '#3B82F6', // blue
                default => '#6B7280', // gray
            };

            return [
                'title' => ($event->facility->name ?? 'Unknown') . ' - ' . \Illuminate\Support\Str::limit($event->purpose, 20),
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
                'backgroundColor' => $statusColor,
                'borderColor' => $statusColor,
                'extendedProps' => [
                    'status' => ucfirst($event->status),
                    'reserver' => $event->reserver->name ?? 'Unknown'
                ]
            ];
        });

        return view('executive.facilities.calendar', compact('bookingsToday', 'utilizationRate', 'calendarEvents'));
    }
}
