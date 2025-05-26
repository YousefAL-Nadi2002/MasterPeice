<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own bookings, admins can view all
    }

    public function view(User $user, Booking $booking): bool
    {
        return $user->is_admin || $booking->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create bookings
    }

    public function update(User $user, Booking $booking): bool
    {
        // Only the booking owner or admin can update
        return $user->is_admin || $booking->user_id === $user->id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        // Only the booking owner or admin can delete
        return $user->is_admin || $booking->user_id === $user->id;
    }

    public function cancel(User $user, Booking $booking): bool
    {
        // Only the booking owner or admin can cancel
        return $user->is_admin || $booking->user_id === $user->id;
    }
}