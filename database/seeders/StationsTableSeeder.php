<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationsTableSeeder extends Seeder
{
    public function run()
    {
        $stations = [
            [
                'name' => 'محطة عمان الأولى',
                'location' => 'شارع المدينة المنورة، عمان',
                'status' => 'active',
                'latitude' => 31.9539,
                'longitude' => 35.9106,
                'available_ports' => 4,
                'total_ports' => 4,
                'charging_types' => json_encode([
                    'DC Fast Charging',
                    'AC Level 2',
                    'Tesla Supercharger'
                ]),
                'operating_hours' => json_encode([
                    'weekdays' => '24/7',
                    'weekend' => '24/7',
                    'holidays' => '24/7'
                ]),
                'amenities' => json_encode([
                    'كافيه',
                    'انتظار مكيف',
                    'واي فاي مجاني',
                    'مصلى'
                ]),
                'description' => 'محطة شحن رئيسية في قلب عمان، متوفرة على مدار الساعة مع جميع أنواع الشواحن'
            ],
            [
                'name' => 'محطة إربد الرئيسية',
                'location' => 'شارع الجامعة، إربد',
                'status' => 'active',
                'latitude' => 32.5556,
                'longitude' => 35.8500,
                'available_ports' => 3,
                'total_ports' => 3,
                'charging_types' => json_encode([
                    'DC Fast Charging',
                    'AC Level 2'
                ]),
                'operating_hours' => json_encode([
                    'weekdays' => '06:00 - 23:00',
                    'weekend' => '08:00 - 22:00',
                    'holidays' => '09:00 - 21:00'
                ]),
                'amenities' => json_encode([
                    'سوبرماركت',
                    'مقهى',
                    'واي فاي مجاني'
                ]),
                'description' => 'محطة شحن حديثة في إربد، قريبة من الجامعات والمراكز التجارية'
            ],
            [
                'name' => 'محطة العقبة',
                'location' => 'شارع الملك حسين، العقبة',
                'status' => 'active',
                'latitude' => 29.5267,
                'longitude' => 35.0078,
                'available_ports' => 2,
                'total_ports' => 2,
                'charging_types' => json_encode([
                    'DC Fast Charging',
                    'AC Level 2'
                ]),
                'operating_hours' => json_encode([
                    'weekdays' => '08:00 - 22:00',
                    'weekend' => '09:00 - 23:00',
                    'holidays' => '09:00 - 21:00'
                ]),
                'amenities' => json_encode([
                    'مطعم',
                    'استراحة مكيفة',
                    'واي فاي مجاني'
                ]),
                'description' => 'محطة شحن مميزة في العقبة، تخدم السياح والمقيمين على مدار الأسبوع'
            ],
            [
                'name' => 'محطة الزرقاء',
                'location' => 'شارع الملك عبدالله، الزرقاء',
                'status' => 'maintenance',
                'latitude' => 32.0625,
                'longitude' => 36.0942,
                'available_ports' => 0,
                'total_ports' => 3,
                'charging_types' => json_encode([
                    'DC Fast Charging',
                    'AC Level 2'
                ]),
                'operating_hours' => json_encode([
                    'weekdays' => '07:00 - 23:00',
                    'weekend' => '08:00 - 22:00',
                    'holidays' => '09:00 - 21:00'
                ]),
                'amenities' => json_encode([
                    'سوبرماركت',
                    'واي فاي مجاني',
                    'مصلى'
                ]),
                'description' => 'محطة شحن رئيسية في الزرقاء، تحت الصيانة حالياً لتحسين الخدمة'
            ]
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
} 