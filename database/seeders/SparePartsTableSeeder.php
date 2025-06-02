<?php

namespace Database\Seeders;

use App\Models\SparePart;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SparePartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');

        // Clear existing spare parts
        SparePart::truncate();

        // Add 30 dummy spare parts with complete Arabic information for available fields
        for ($i = 0; $i < 30; $i++) {
            SparePart::create([
                'name' => 'قطعة غيار ' . $faker->unique()->word, // اسم قطعة غيار عربي فريد
                'description' => $faker->realText(200), // وصف عربي أطول وأكثر واقعية
                'price' => $faker->randomFloat(2, 50, 2000), // سعر عشوائي بين 50 و 2000
                'stock' => $faker->numberBetween(0, 50), // مخزون عشوائي بين 0 و 50
                'status' => $faker->randomElement(['available', 'unavailable']), // حالة متوفر أو غير متوفر
                'image' => null, // لا يوجد صورة (يمكنك توليد مسارات صور وهمية إذا أردت)
            ]);
        }
    }
}
