<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Booking;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    // عرض الصفحة الرئيسية
    public function home()
    {
        $activeStations = Station::where('status', 'active')->count();
        $totalBookings = Booking::count();
        return view('Home', compact('activeStations', 'totalBookings'));
    }

    // عرض صفحة الخريطة
    public function map()
    {
        $stations = Station::where('status', 'active')->get();
        return view('map', compact('stations'));
    }

    // عرض صفحة أقرب محطة
    public function nearest()
    {
        $stations = Station::where('status', 'active')->get();
        return view('nearest', compact('stations'));
    }

    // عرض صفحة حول الموقع
    public function about()
    {
        return view('about');
    }

    // عرض صفحة اتصل بنا
    public function contact()
    {
        return view('contact');
    }

    // عرض صفحة الموقع
    public function location()
    {
        $stations = Station::where('status', 'active')->get();
        return view('location', compact('stations'));
    }

    // عرض صفحة حول الموقع      
    public function stations()
    {
        $stations = Station::where('status', 'active')->get();
        return view('stations', compact('stations'));
    }

    // عرض صفحة حول الموقع
    public function aboutUs()
    {
        return view('about-us');
    }

    // عرض صفحة حول الموقع
    public function maintenance()
    {
        return view('maintenance');
    }

    public function help()
    {
        return view('help');
    }

    public function profile()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with('station')->latest()->get();
        $maintenanceRequests = $user->maintenanceRequests()->with('station')->latest()->get();
        return view('profile', compact('user', 'bookings', 'maintenanceRequests'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'car_model' => 'required|string|max:255',
        ]);

        $user->update($validated);
        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function myBookings()
    {
        $bookings = auth()->user()->bookings()->with('station')->latest()->paginate(10);
        return view('my-bookings', compact('bookings'));
    }

    public function myMaintenanceRequests()
    {
        $requests = auth()->user()->maintenanceRequests()->with('station')->latest()->paginate(10);
        return view('my-maintenance-requests', compact('requests'));
    }
}
