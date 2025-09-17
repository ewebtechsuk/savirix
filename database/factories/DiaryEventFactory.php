<?php

namespace Database\Factories;

use App\Models\DiaryEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiaryEventFactory extends Factory
{
    protected $model = DiaryEvent::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 month');
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(8),
            'date' => $start->format('Y-m-d'),
            'start' => $start,
            'type' => $this->faker->randomElement(['appointment', 'viewing', 'inspection']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
