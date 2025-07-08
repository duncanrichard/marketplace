<?php

namespace App\Http\Controllers;

use App\Models\PengajuanEvent;
use App\Models\Visit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter tanggal dan event
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $selectedEvent = $request->event;

        // Default filter tanggal jika tidak diisi
        if (!$startDate || !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        // Query Event berdasarkan filter
        $eventQuery = PengajuanEvent::query()
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->where('status', 'Confirmed');

        if ($selectedEvent) {
            $eventQuery->where('judul', $selectedEvent);
        }

        $events = $eventQuery->withCount('praMembers')->get();

        // Data untuk chart Event
        $eventNames = $events->pluck('judul');
        $memberCounts = $events->pluck('pra_members_count');

        // Semua judul event unik untuk dropdown
        $allEvents = PengajuanEvent::select('judul')->distinct()->orderBy('judul')->get();

        // Event hari ini
        $todayEvents = PengajuanEvent::whereDate('tanggal', Carbon::today())
            ->where('status', 'Confirmed')
            ->with(['praMembers'])
            ->withCount('praMembers')
            ->get();

        // Data kunjungan berdasarkan filter tanggal yang sama
        $visits = Visit::whereBetween('tanggal_kunjungan', [$startDate, $endDate])->get();

        $visitSummary = $visits->groupBy('tanggal_kunjungan')->map(function ($group) {
            return count($group);
        });

        $visitDates = $visitSummary->keys()->map(fn($date) => Carbon::parse($date)->format('d M'));
        $visitCounts = $visitSummary->values();
        $eventsTable = clone $events;

        return view('dashboard.index', compact(
            'eventNames',
            'memberCounts',
            'startDate',
            'endDate',
            'allEvents',
            'selectedEvent',
            'todayEvents',
            'visitDates',
            'visitCounts',
            'eventsTable'
        ));
    }
}