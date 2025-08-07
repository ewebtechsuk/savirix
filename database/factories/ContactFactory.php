<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $firstName . ' ' . $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'type' => $this->faker->randomElement(['landlord', 'applicant', 'tenant', 'other']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
