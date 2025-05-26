<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Rating;

class DashboardController extends Controller
{
    public function index()
    {
        $activeStations = Station::where('status', 'active')->count();
        $totalStations = Station::count();
        $totalBookings = Booking::count();
        $totalUsers = User::where('is_admin', false)->count();
        $pendingMaintenance = MaintenanceRequest::where('status', 'pending')->count();
        $todayBookings = Booking::whereDate('created_at', Carbon::today())->count();
        $activeUsers = User::where('is_admin', false)->where('is_active', true)->count();

        // For charts/statistics
        $stationsStats = (object)[
            'active' => Station::where('status', 'active')->count(),
            'maintenance' => Station::where('status', 'maintenance')->count(),
            'inactive' => Station::where('status', 'inactive')->count(),
        ];

        $bookingsStats = (object)[
            'labels' => [],
            'data' => [],
        ];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $bookingsStats->labels[] = $date->format('Y-m-d');
            $bookingsStats->data[] = Booking::whereDate('created_at', $date)->count();
        }

        $recentRatings = Rating::with(['user', 'station'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'station'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $unreadNotifications = auth()->user()->unreadNotifications ?? collect();
        $unreadNotificationsCount = $unreadNotifications->count();

        return view('admin.dashboard', compact(
            'activeStations',
            'totalStations',
            'totalBookings',
            'totalUsers',
            'pendingMaintenance',
            'todayBookings',
            'stationsStats',
            'bookingsStats',
            'activeUsers',
            'recentRatings',
            'recentBookings',
            'unreadNotifications',
            'unreadNotificationsCount'
        ));
    }
}
