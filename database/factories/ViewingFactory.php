<?php

namespace Database\Factories;

use App\Models\Viewing;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewingFactory extends Factory
{
    protected $model = Viewing::class;

    public function definition()
    {
        return [
            'property_id' => \App\Models\Property::factory(),
            'contact_id' => \App\Models\Contact::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'notes' => $this->faker->sentence(8),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
