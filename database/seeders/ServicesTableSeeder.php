<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');

        // Add 50 electrical services
        for ($i = 0; $i < 50; $i++) {
            Service::create([
                'name' => 'خدمة كهربائية ' . $faker->unique()->word, // اسم خدمة كهربائية عربي فريد
                'description' => $faker->realText(150), // وصف عربي للخدمة
                'type' => 'electrical',
                'is_active' => true,
                'price' => $faker->randomFloat(2, 20, 500), // سعر عشوائي
                'sort_order' => $faker->numberBetween(1, 100),
                'image' => null, // لا يوجد صورة
            ]);
        }

        // Add 50 mechanical services
        for ($i = 0; $i < 50; $i++) {
            Service::create([
                'name' => 'خدمة ميكانيكية ' . $faker->unique()->word, // اسم خدمة ميكانيكية عربي فريد
                'description' => $faker->realText(150), // وصف عربي للخدمة
                'type' => 'mechanical',
                'is_active' => true,
                'price' => $faker->randomFloat(2, 30, 600), // سعر عشوائي
                'sort_order' => $faker->numberBetween(1, 100),
                'image' => null, // لا يوجد صورة
            ]);
        }
    }
}
