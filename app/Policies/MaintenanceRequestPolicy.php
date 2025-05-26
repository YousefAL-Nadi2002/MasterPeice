<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenanceRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Users can view their own requests, admins can view all
    }

    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->is_admin || $maintenanceRequest->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can create maintenance requests
    }

    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Only admins can update maintenance requests
        return $user->is_admin;
    }

    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Only admins can delete maintenance requests
        return $user->is_admin;
    }

    public function cancel(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Only the request creator or admin can cancel
        return $user->is_admin || $maintenanceRequest->user_id === $user->id;
    }

    public function viewHistory(User $user): bool
    {
        // Only admins can view maintenance history
        return $user->is_admin;
    }
} 