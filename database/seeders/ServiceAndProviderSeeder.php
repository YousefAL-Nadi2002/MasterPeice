<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServiceAndProviderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ar_SA');

        // Optional: Truncate tables if you want a clean seed each time
        // DB::table('provider_service')->truncate();
        // ServiceProvider::truncate();
        // Service::truncate();

        // Generate and seed 50 electrical services
        for ($i = 0; $i < 50; $i++) {
            $service = Service::create([
                'name' => 'خدمة كهربائية ' . $faker->unique()->word,
                'description' => $faker->realText(200),
                'type' => 'electrical',
                'is_active' => true,
                'price' => $faker->randomFloat(2, 50, 1500),
                'sort_order' => $faker->numberBetween(1, 100),
                'image' => null,
            ]);

            $providerCount = $faker->numberBetween(1, 5);
            for($j = 0; $j < $providerCount; $j++) {
                 $provider = ServiceProvider::firstOrCreate(
                     ['phone' => $faker->unique()->phoneNumber],
                     [
                        'name' => 'مزود خدمة ' . $faker->company,
                        'whatsapp' => $faker->phoneNumber,
                        'email' => $faker->unique()->safeEmail,
                        'location' => $faker->address,
                     ]
                 );
                 $service->providers()->syncWithoutDetaching([$provider->id]);
            }
        }

        // Generate and seed 50 mechanical services
        for ($i = 0; $i < 50; $i++) {
            $service = Service::create([
                'name' => 'خدمة ميكانيكية ' . $faker->unique()->word,
                'description' => $faker->realText(200),
                'type' => 'mechanical',
                'is_active' => true,
                'price' => $faker->randomFloat(2, 70, 2000),
                'sort_order' => $faker->numberBetween(1, 100),
                'image' => null,
            ]);

            $providerCount = $faker->numberBetween(1, 5);
            for($j = 0; $j < $providerCount; $j++) {
                 $provider = ServiceProvider::firstOrCreate(
                     ['phone' => $faker->unique()->phoneNumber],
                     [
                        'name' => 'مزود خدمة ' . $faker->company,
                        'whatsapp' => $faker->phoneNumber,
                        'email' => $faker->unique()->safeEmail,
                        'location' => $faker->address,
                     ]
                 );
                 $service->providers()->syncWithoutDetaching([$provider->id]);
            }
        }

        // The original code had a fixed list of services and providers.
        // This new code generates random services and providers using Faker.
        // If you need specific services or providers, you would revert to a structure
        // similar to the original or combine both approaches.
    }
} 