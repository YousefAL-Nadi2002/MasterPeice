<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use Arabic Faker for Arabic content
        $faker = Faker::create('ar_SA');

        // Jordan Cities
        $jordanCities = ['Amman', 'Irbid', 'Zarqa', 'Aqaba', 'Salt', 'Karak', "Ma'an", 'Jerash'];

        // Other Arab Countries and Cities (simplified list)
        $arabLocations = [
            'Saudi Arabia' => ['الرياض', 'جدة', 'الدمام'],
            'Egypt' => ['القاهرة', 'الإسكندرية', 'الجيزة'],
            'UAE' => ['دبي', 'أبو ظبي', 'الشارقة'],
            'Morocco' => ['الدار البيضاء', 'الرباط', 'مراكش'],
            'Algeria' => ['الجزائر', 'وهران'],
            'Tunisia' => ['تونس', 'صفاقس'],
            'Qatar' => ['الدوحة'],
            'Kuwait' => ['مدينة الكويت'],
            'Bahrain' => ['المنامة'],
        ];

        // Foreign Countries and Cities (simplified list)
        $foreignLocations = [
            'USA' => ['New York', 'Los Angeles', 'Chicago'],
            'Germany' => ['Berlin', 'Munich', 'Frankfurt'],
            'France' => ['Paris', 'Marseille'],
            'UK' => ['London', 'Manchester'],
            'Japan' => ['Tokyo', 'Osaka'],
            'China' => ['Shanghai', 'Beijing'],
        ];

        $statuses = ['active', 'maintenance', 'inactive']; // قد تحتاج لترجمة هذه الحالة في الواجهة الأمامية
        $chargingTypes = ['Type 1', 'Type 2', 'CCS', 'CHAdeMO', 'Tesla Supercharger']; // هذه الأنواع غالباً ما تبقى بالإنجليزية كمعايير
        $amenities = ['مقهى', 'دورة مياه', 'واي فاي مجاني', 'مطعم', 'منطقة انتظار'];

        // Clear existing stations
        Station::truncate();

        // Add 150 stations in Jordan
        for ($i = 0; $i < 150; $i++) {
            $city = Arr::random($jordanCities);
            $name = $faker->randomElement(['محطة ' . $city . ' للشحن السريع', 'محطة ' . $city . ' الرئيسية', 'محطة ' . $city . ' للسيارات الكهربائية']);
            Station::create([
                'name' => $name,
                'location' => $city . ', الأردن',
                'latitude' => $faker->latitude(29.1, 33.7),
                'longitude' => $faker->longitude(34.9, 39.3),
                'available_ports' => $faker->numberBetween(1, 8),
                'total_ports' => $faker->numberBetween(8, 12),
                'status' => Arr::random($statuses),
                'charging_types' => json_encode($faker->randomElements($chargingTypes, $faker->numberBetween(1, 4))),
                'operating_hours' => json_encode(['weekdays' => '24/7', 'weekend' => '24/7']),
                'amenities' => json_encode($faker->randomElements($amenities, $faker->numberBetween(0, 3))),
                'description' => $faker->realText(100), // وصف باللغة العربية (تم تقليل الطول)
            ]);
        }

        // Add 20 stations in other Arab countries
        $fakerOther = Faker::create(); // Use default faker for non-Arabic names if needed, or create with locale for that country
        for ($i = 0; $i < 20; $i++) {
            $country = Arr::random(array_keys($arabLocations));
            $city = Arr::random($arabLocations[$country]);
             $name = $fakerOther->randomElement([$fakerOther->company, $city . ' Station', 'محطة ' . $city]); // يمكن مزج الأسماء أو استخدام faker بلغة البلد
            Station::create([
                'name' => $name,
                'location' => $city . ', ' . $country,
                'latitude' => $fakerOther->latitude,
                'longitude' => $fakerOther->longitude,
                'available_ports' => $fakerOther->numberBetween(1, 10),
                'total_ports' => $fakerOther->numberBetween(10, 15),
                'status' => Arr::random($statuses),
                'charging_types' => json_encode($fakerOther->randomElements($chargingTypes, $fakerOther->numberBetween(1, 5))),
                'operating_hours' => json_encode(['weekdays' => '24/7', 'weekend' => '24/7']),
                'amenities' => json_encode($fakerOther->randomElements($amenities, $fakerOther->numberBetween(0, 4))),
                'description' => $fakerOther->sentence, // وصف باللغة الإنجليزية غالباً
            ]);
        }

        // Add 10 stations in foreign countries
        $fakerForeign = Faker::create(); // Use default faker
        for ($i = 0; $i < 10; $i++) {
            $country = Arr::random(array_keys($foreignLocations));
            $city = Arr::random($foreignLocations[$country]);
            $name = $fakerForeign->randomElement([$fakerForeign->company . ' Charging', $city . ' EV Hub']);
            Station::create([
                'name' => $name,
                'location' => $city . ', ' . $country,
                'latitude' => $fakerForeign->latitude,
                'longitude' => $fakerForeign->longitude,
                'available_ports' => $fakerForeign->numberBetween(1, 12),
                'total_ports' => $fakerForeign->numberBetween(12, 20),
                'status' => Arr::random($statuses),
                'charging_types' => json_encode($fakerForeign->randomElements($chargingTypes, $fakerForeign->numberBetween(2, 5))),
                'operating_hours' => json_encode(['weekdays' => '24/7', 'weekend' => '24/7']),
                'amenities' => json_encode($fakerForeign->randomElements($amenities, $fakerForeign->numberBetween(1, 5))),
                'description' => $fakerForeign->sentence,
            ]);
        }
    }
} 