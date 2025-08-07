<?php

namespace Database\Factories;

use App\Models\Landlord;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandlordFactory extends Factory
{
    protected $model = Landlord::class;

    public function definition()
    {
        return [
            'person_firstname' => $this->faker->firstName(),
            'person_lastname' => $this->faker->lastName(),
            'person_company' => $this->faker->company(),
            'person_title' => $this->faker->title(),
            'person_salutation' => $this->faker->title(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_phone_home' => $this->faker->phoneNumber(),
            'contact_phone_work' => $this->faker->phoneNumber(),
            'contact_phone_mobile' => $this->faker->phoneNumber(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
