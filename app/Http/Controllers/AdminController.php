<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
 public function __construct()
 {
         $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_stations' => Station::count(),
            'active_stations' => Station::where('status', 'active')->count(),
            'maintenance_stations' => Station::where('status', 'maintenance')->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_maintenance_requests' => MaintenanceRequest::count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'total_users' => User::where('is_admin', false)->count(),
        ];

        $recent_bookings = Booking::with(['user', 'station'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_maintenance = MaintenanceRequest::with(['station'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_maintenance'));
    }

    public function stations()
    {
        $stations = Station::withCount(['bookings', 'maintenanceRequests'])->get();
        return view('admin.stations', compact('stations'));
    }

    public function storeStation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'total_ports' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['available_ports'] = $data['total_ports'];
        
        Station::create($data);
        return redirect()->route('admin.stations.index')->with('success', 'تم إضافة المحطة بنجاح');
    }

    public function updateStation(Request $request, Station $station)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'total_ports' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $station->update($validator->validated());
        return redirect()->route('admin.stations.index')->with('success', 'تم تحديث المحطة بنجاح');
    }

    public function deleteStation(Station $station)
    {
        $station->delete();
        return response()->json(['success' => true]);
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'station'])->orderBy('created_at', 'desc')->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function maintenance()
    {
        $requests = MaintenanceRequest::with(['station'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.maintenance', compact('requests'));
    }

    public function users()
    {
        $users = User::where('is_admin', false)
            ->withCount(['bookings'])
            ->get();
        return view('admin.users', compact('users'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $booking->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function updateMaintenanceStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $maintenance->update(['status' => $request->status]);

        // تحديث حالة المحطة إذا تم إكمال الصيانة
        if ($request->status === 'completed') {
            $maintenance->station->update(['status' => 'active']);
        }

        return response()->json(['success' => true]);
    }

    public function toggleUserStatus(User $user)
    {
        if ($user->is_admin) {
            return response()->json(['success' => false, 'message' => 'لا يمكن تغيير حالة المشرف'], 403);
        }

        $user->update(['is_active' => !$user->is_active]);
        return response()->json(['success' => true]);
    }
}