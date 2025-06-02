<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use Illuminate\Support\Facades\Storage;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::withCount(['bookings', 'maintenanceRequests'])
            ->latest()
            ->paginate(10);
        $chargerTypes = [
            'type1' => 'Type 1',
            'type2' => 'Type 2',
            'ccs' => 'CCS',
            'chademo' => 'CHAdeMO',
            'tesla' => 'Tesla',
        ];
        return view('admin.stations.index', compact('stations', 'chargerTypes'));
    }

    public function create()
    {
        return view('admin.stations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'address_ar' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'city_ar' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
            'total_ports' => 'nullable|integer',
            'available_ports' => 'nullable|integer',
            'charging_types' => 'nullable|array',
            'charging_types.*' => 'string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'contact_number' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('stations', 'public');
        }
        if (isset($validated['charging_types'])) {
            $validated['charging_types'] = json_encode($validated['charging_types']);
        }
        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }
        Station::create($validated);

        return redirect()->route('admin.stations.index')
            ->with('success', 'تم إضافة محطة الشحن بنجاح');
    }

    public function show(Station $station)
    {
        $station->load(['bookings', 'maintenanceRequests']);
        return view('admin.stations.show', compact('station'));
    }

    public function edit(Station $station)
    {
        return view('admin.stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'address_ar' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'city_ar' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,inactive',
            'total_ports' => 'nullable|integer',
            'available_ports' => 'nullable|integer',
            'charging_types' => 'nullable|array',
            'charging_types.*' => 'string',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string',
            'opening_time' => 'nullable',
            'closing_time' => 'nullable',
            'contact_number' => 'nullable|string|max:255',
            'emergency_number' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('image')) {
            if ($station->image) {
                Storage::disk('public')->delete($station->image);
            }
            $validated['image'] = $request->file('image')->store('stations', 'public');
        }
        if (isset($validated['charging_types'])) {
            $validated['charging_types'] = json_encode($validated['charging_types']);
        }
        if (isset($validated['amenities'])) {
            $validated['amenities'] = json_encode($validated['amenities']);
        }
        $station->update($validated);

        return redirect()->route('admin.stations.index')
            ->with('success', 'تم تحديث محطة الشحن بنجاح');
    }

    public function destroy(Station $station)
    {
        if ($station->image) {
            Storage::disk('public')->delete($station->image);
        }

        $station->delete();

        return redirect()->route('admin.stations.index')
            ->with('success', 'تم حذف محطة الشحن بنجاح');
    }

    public function toggleStatus(Station $station)
    {
        $newStatus = $station->status === 'active' ? 'inactive' : 'active';
        $station->update(['status' => $newStatus]);

        return redirect()->route('admin.stations.index')
            ->with('success', 'تم تغيير حالة محطة الشحن بنجاح');
    }
}
