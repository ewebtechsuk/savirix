<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'address' => $this->faker->address(),
            'price' => $this->faker->numberBetween(100000, 500000),
            'description' => $this->faker->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
