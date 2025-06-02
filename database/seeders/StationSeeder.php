<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Station;
use Faker\Factory as Faker;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed 100 stations in Jordan
        for ($i = 0; $i < 100; $i++) {
            Station::create([
                'name' => 'Station ' . $faker->word,
                'latitude' => $faker->latitude(30.5, 33.5),
                'longitude' => $faker->longitude(35.0, 39.0),
                'location' => 'Jordan - ' . $faker->city,
                'total_ports' => $faker->numberBetween(1, 10),
                'available_ports' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['active', 'maintenance', 'inactive']),
                'charger_type' => $faker->randomElement(['Type 1', 'Type 2', 'CCS', 'CHAdeMO']),
                'description' => $faker->sentence,
            ]);
        }

        // Seed 100 stations in Arab countries
        $arabCountries = [
            'Saudi Arabia', 'Egypt', 'UAE', 'Qatar', 'Kuwait', 'Bahrain', 'Oman',
            'Iraq', 'Syria', 'Lebanon', 'Palestine', 'Yemen', 'Libya', 'Tunisia',
            'Algeria', 'Morocco', 'Sudan', 'Somalia', 'Djibouti', 'Mauritania',
        ];

        for ($i = 0; $i < 100; $i++) {
            $country = $faker->randomElement($arabCountries);
            Station::create([
                'name' => 'Station ' . $faker->word,
                'latitude' => $faker->latitude(-10, 40),
                'longitude' => $faker->longitude(-20, 60),
                'location' => $country . ' - ' . $faker->city,
                'total_ports' => $faker->numberBetween(1, 10),
                'available_ports' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['active', 'maintenance', 'inactive']),
                'charger_type' => $faker->randomElement(['Type 1', 'Type 2', 'CCS', 'CHAdeMO']),
                'description' => $faker->sentence,
            ]);
        }

        // Seed 100 stations in foreign countries
        $foreignCountries = [
            'USA', 'Germany', 'France', 'UK', 'China', 'Japan', 'Canada', 'Australia', 'India', 'Brazil',
            'Russia', 'Italy', 'Spain', 'Mexico', 'Indonesia', 'Turkey', 'Pakistan', 'Nigeria', 'Bangladesh',
        ];

        for ($i = 0; $i < 100; $i++) {
            $country = $faker->randomElement($foreignCountries);
            Station::create([
                'name' => 'Station ' . $faker->word,
                'latitude' => $faker->latitude(-60, 70),
                'longitude' => $faker->longitude(-180, 180),
                'location' => $country . ' - ' . $faker->city,
                'total_ports' => $faker->numberBetween(1, 10),
                'available_ports' => $faker->numberBetween(1, 10),
                'status' => $faker->randomElement(['active', 'maintenance', 'inactive']),
                'charger_type' => $faker->randomElement(['Type 1', 'Type 2', 'CCS', 'CHAdeMO']),
                'description' => $faker->sentence,
            ]);
        }
    }
}
