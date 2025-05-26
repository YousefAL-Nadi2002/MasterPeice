<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('station')
            ->where('user_id', auth()->id())
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('start_time', 'desc')
            ->get();

        return response()->json(['data' => $bookings]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'station_id' => 'required|exists:stations,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'vehicle_model' => 'required|string',
            'vehicle_plate' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the station is available for the requested time slot
        $conflictingBookings = Booking::where('station_id', $request->station_id)
            ->where('status', 'confirmed')
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->count();

        if ($conflictingBookings > 0) {
            return response()->json([
                'message' => 'The selected time slot is not available'
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'station_id' => $request->station_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'vehicle_model' => $request->vehicle_model,
            'vehicle_plate' => $request->vehicle_plate,
            'notes' => $request->notes,
            'status' => 'confirmed', // Auto-confirm for now
        ]);

        return response()->json(['data' => $booking], 201);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load('station');
        return response()->json(['data' => $booking]);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status === 'completed' || $booking->status === 'cancelled') {
            return response()->json([
                'message' => 'Cannot modify a completed or cancelled booking'
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'start_time' => 'sometimes|date|after:now',
            'end_time' => 'sometimes|date|after:start_time',
            'vehicle_model' => 'sometimes|string',
            'vehicle_plate' => 'sometimes|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->has('start_time') || $request->has('end_time')) {
            $startTime = $request->start_time ?? $booking->start_time;
            $endTime = $request->end_time ?? $booking->end_time;

            $conflictingBookings = Booking::where('station_id', $booking->station_id)
                ->where('id', '!=', $booking->id)
                ->where('status', 'confirmed')
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime])
                        ->orWhereBetween('end_time', [$startTime, $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                        });
                })
                ->count();

            if ($conflictingBookings > 0) {
                return response()->json([
                    'message' => 'The selected time slot is not available'
                ], 422);
            }
        }

        $booking->update($request->all());

        return response()->json(['data' => $booking]);
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        if ($booking->status !== 'confirmed') {
            return response()->json([
                'message' => 'Only confirmed bookings can be cancelled'
            ], 422);
        }

        if (Carbon::parse($booking->start_time)->subHours(2)->isPast()) {
            return response()->json([
                'message' => 'Bookings can only be cancelled at least 2 hours before the start time'
            ], 422);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json(['data' => $booking]);
    }

    public function getAvailableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'station_id' => 'required|exists:stations,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $date = Carbon::parse($request->date);
        $station = Station::findOrFail($request->station_id);

        // Get all confirmed bookings for the requested date
        $bookings = Booking::where('station_id', $station->id)
            ->where('status', 'confirmed')
            ->whereDate('start_time', $date)
            ->orderBy('start_time')
            ->get(['start_time', 'end_time']);

        // Generate available time slots (assuming 30-minute intervals)
        $slots = [];
        $currentSlot = $date->copy()->setTime(6, 0); // Start at 6 AM
        $endTime = $date->copy()->setTime(22, 0); // End at 10 PM

        while ($currentSlot < $endTime) {
            $slotEnd = $currentSlot->copy()->addMinutes(30);
            
            $isAvailable = true;
            foreach ($bookings as $booking) {
                if ($currentSlot->between($booking->start_time, $booking->end_time) ||
                    $slotEnd->between($booking->start_time, $booking->end_time)) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $slots[] = [
                    'start' => $currentSlot->format('Y-m-d H:i:s'),
                    'end' => $slotEnd->format('Y-m-d H:i:s'),
                ];
            }

            $currentSlot->addMinutes(30);
        }

        return response()->json(['data' => $slots]);
    }
}