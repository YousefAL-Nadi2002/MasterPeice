<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::active()->get();
        return response()->json(['data' => $stations]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'charging_types' => 'required|array',
            'available_ports' => 'required|integer|min:1',
            'price_per_kwh' => 'nullable|numeric',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $station = Station::create($request->all());
        
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('stations', 'public');
                $images[] = asset('storage/' . $path);
            }
            $station->update(['images' => $images]);
        }

        return response()->json(['data' => $station], 201);
    }

    public function show(Station $station)
    {
        return response()->json(['data' => $station]);
    }

    public function update(Request $request, Station $station)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'charging_types' => 'sometimes|array',
            'available_ports' => 'sometimes|integer|min:1',
            'price_per_kwh' => 'nullable|numeric',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $station->update($request->except('images'));

        if ($request->hasFile('images')) {
            $images = $station->images ?? [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('stations', 'public');
                $images[] = asset('storage/' . $path);
            }
            $station->update(['images' => $images]);
        }

        return response()->json(['data' => $station]);
    }

    public function destroy(Station $station)
    {
        $station->delete();
        return response()->json(null, 204);
    }

    public function nearby(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stations = Station::active()
            ->nearby($request->latitude, $request->longitude, $request->radius ?? 10)
            ->get();

        return response()->json(['data' => $stations]);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $stations = Station::active()
            ->where(function($query) use ($request) {
                $searchTerm = $request->query;
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('address', 'like', "%{$searchTerm}%");
            })
            ->get();

        return response()->json(['data' => $stations]);
    }
} 