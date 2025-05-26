<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $maintenanceRequests = MaintenanceRequest::with('station')
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->when(!auth()->user()->is_admin, function($query) {
                return $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $maintenanceRequests]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'station_id' => 'required|exists:stations,id',
            'type' => 'required|in:emergency,scheduled,repair',
            'description' => 'required|string',
            'scheduled_at' => 'required_if:type,scheduled|nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $station = Station::findOrFail($request->station_id);

        // For emergency requests, automatically set station status to maintenance
        if ($request->type === 'emergency') {
            $station->update(['status' => 'maintenance']);
        }

        $maintenanceRequest = MaintenanceRequest::create([
            'station_id' => $request->station_id,
            'user_id' => auth()->id(),
            'type' => $request->type,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'status' => $request->type === 'emergency' ? 'in_progress' : 'pending',
        ]);

        return response()->json(['data' => $maintenanceRequest], 201);
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('view', $maintenanceRequest);
        
        $maintenanceRequest->load('station', 'user');
        return response()->json(['data' => $maintenanceRequest]);
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('update', $maintenanceRequest);

        if ($maintenanceRequest->status === 'completed') {
            return response()->json([
                'message' => 'Cannot modify a completed maintenance request'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,in_progress,completed,cancelled',
            'description' => 'sometimes|string',
            'scheduled_at' => 'sometimes|nullable|date|after:now',
            'resolution_notes' => 'required_if:status,completed|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // If completing the request, update the station status
        if ($request->status === 'completed' && $maintenanceRequest->status !== 'completed') {
            $maintenanceRequest->completed_at = now();
            
            // Update station status back to active
            $maintenanceRequest->station->update(['status' => 'active']);
        }

        $maintenanceRequest->update($request->all());

        return response()->json(['data' => $maintenanceRequest]);
    }

    public function cancel(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorize('update', $maintenanceRequest);

        if ($maintenanceRequest->status === 'completed') {
            return response()->json([
                'message' => 'Cannot cancel a completed maintenance request'
            ], 422);
        }

        // If cancelling an emergency request, check if there are other active emergency requests
        if ($maintenanceRequest->type === 'emergency' && $maintenanceRequest->status === 'in_progress') {
            $otherEmergencyRequests = MaintenanceRequest::where('station_id', $maintenanceRequest->station_id)
                ->where('id', '!=', $maintenanceRequest->id)
                ->where('type', 'emergency')
                ->where('status', 'in_progress')
                ->count();

            // If no other emergency requests, set station back to active
            if ($otherEmergencyRequests === 0) {
                $maintenanceRequest->station->update(['status' => 'active']);
            }
        }

        $maintenanceRequest->update([
            'status' => 'cancelled',
            'resolution_notes' => 'Request cancelled by ' . auth()->user()->name
        ]);

        return response()->json(['data' => $maintenanceRequest]);
    }

    public function getStationHistory(Request $request, Station $station)
    {
        $maintenanceHistory = MaintenanceRequest::where('station_id', $station->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $maintenanceHistory]);
    }
} 