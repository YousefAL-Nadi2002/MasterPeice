<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\Station;
use App\Policies\BookingPolicy;
use App\Policies\MaintenanceRequestPolicy;
use App\Policies\StationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Station::class => StationPolicy::class,
        Booking::class => BookingPolicy::class,
        MaintenanceRequest::class => MaintenanceRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define a gate for admin access
        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}
