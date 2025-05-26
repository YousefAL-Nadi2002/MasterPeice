<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // تنظيف جميع الجداول قبل إضافة البيانات
        $this->call([
            UsersTableSeeder::class,
            StationsTableSeeder::class,
            MaintenanceRequestsTableSeeder::class,
        ]);

        // إنشاء بعض الحجوزات للاختبار
        \App\Models\Booking::factory(10)->create();
    }
}
