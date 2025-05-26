<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        $station = Station::inRandomOrder()->first();
        $start_time = $this->faker->dateTimeBetween('now', '+1 week');
        $end_time = (clone $start_time)->modify('+2 hours');

        return [
            'user_id' => User::where('is_admin', false)->inRandomOrder()->first()->id,
            'station_id' => $station->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'port_number' => $this->faker->numberBetween(1, $station->total_ports),
            'notes' => $this->faker->optional()->sentence
        ];
    }
} 