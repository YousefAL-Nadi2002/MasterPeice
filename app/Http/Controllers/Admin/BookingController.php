<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Station;
use App\Models\User;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'station'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $stations = Station::all();
        $users = User::where('is_admin', false)->get();
        return view('admin.bookings.index', compact('bookings', 'stations', 'users'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function create()
    {
        $users = \App\Models\User::where('is_admin', false)->get();
        $stations = \App\Models\Station::where('status', 'active')->get();
        return view('admin.bookings.create', compact('users', 'stations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'station_id' => 'required|exists:stations,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $booking = \App\Models\Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم إضافة الحجز بنجاح');
    }

    public function edit(Booking $booking)
    {
        $users = \App\Models\User::where('is_admin', false)->get();
        $stations = \App\Models\Station::where('status', 'active')->get();
        return view('admin.bookings.edit', compact('booking', 'users', 'stations'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:1000',
        ]);

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم تحديث الحجز بنجاح');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->status === 'completed') {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'لا يمكن حذف حجز مكتمل');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم حذف الحجز بنجاح');
    }
}
