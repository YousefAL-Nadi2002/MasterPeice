<?php

namespace Database\Seeders;

use App\Models\MaintenanceRequest;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaintenanceRequestsTableSeeder extends Seeder
{
    public function run()
    {
        $admin = User::where('is_admin', true)->first();
        $stations = Station::all();

        // إنشاء طلب صيانة طارئ
        MaintenanceRequest::create([
            'station_id' => $stations->where('status', 'maintenance')->first()->id,
            'user_id' => $admin->id,
            'type' => 'emergency',
            'description' => 'عطل في نظام الشحن الرئيسي',
            'status' => 'in_progress',
            'priority' => 'high',
            'scheduled_date' => now(),
            'completed_date' => null
        ]);

        // إنشاء طلب صيانة مجدول
        MaintenanceRequest::create([
            'station_id' => $stations->where('status', 'active')->first()->id,
            'user_id' => $admin->id,
            'type' => 'scheduled',
            'description' => 'صيانة دورية للمحطة',
            'status' => 'pending',
            'priority' => 'medium',
            'scheduled_date' => now()->addDays(7),
            'completed_date' => null
        ]);

        // إنشاء طلب إصلاح مكتمل
        MaintenanceRequest::create([
            'station_id' => $stations->where('status', 'active')->first()->id,
            'user_id' => $admin->id,
            'type' => 'repair',
            'description' => 'استبدال كابل الشحن التالف',
            'status' => 'completed',
            'priority' => 'medium',
            'scheduled_date' => now()->subDays(5),
            'completed_date' => now()->subDays(4)
        ]);
    }
} 