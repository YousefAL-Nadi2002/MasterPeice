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
    public function run(): void
    {
        // تنظيف جميع الجداول قبل إضافة البيانات
        $this->call([
            AdminSeeder::class,
            UsersTableSeeder::class,
            StationsTableSeeder::class,
            MaintenanceRequestsTableSeeder::class,
            SparePartsTableSeeder::class,
            ServicesTableSeeder::class,
        ]);

        // إنشاء بعض الحجوزات للاختبار
        \App\Models\Booking::factory(10)->create();
    }
}
