<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SparePart;
use Faker\Factory as Faker;

class SparePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed 100 spare parts for electric vehicles
        for ($i = 0; $i < 100; $i++) {
            SparePart::create([
                'name' => $faker->unique()->word . ' Electric Vehicle Part',
                'description' => $faker->sentence(10),
                'price' => $faker->randomFloat(2, 10, 1000),
                'stock' => $faker->numberBetween(0, 200),
                'details' => json_encode([
                    'manufacturer' => $faker->company,
                    'part_number' => $faker->uuid,
                    'compatibility' => 'Compatible with ' . $faker->randomElement(['Tesla', 'Nissan Leaf', 'Chevrolet Bolt', 'Hyundai Kona EV']) . ' and others',
                    'weight_kg' => $faker->randomFloat(2, 0.1, 50),
                ]),
            ]);
        }
    }
}
