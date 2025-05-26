<?php

namespace App\Policies;

use App\Models\Station;
use App\Models\User;

class StationPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view stations
    }

    public function view(User $user, Station $station): bool
    {
        return true; // Anyone can view a station
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Station $station): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Station $station): bool
    {
        return $user->is_admin;
    }
}