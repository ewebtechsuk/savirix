<?php

namespace Database\Factories;

use App\Models\Inspection;
use Illuminate\Database\Eloquent\Factories\Factory;

class InspectionFactory extends Factory
{
    protected $model = Inspection::class;

    public function definition()
    {
        return [
            'property_id' => \App\Models\Property::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'result' => $this->faker->sentence(6),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
