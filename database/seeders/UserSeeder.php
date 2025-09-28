<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)->create();

        User::updateOrCreate(
            ['email' => 'demo@ressapp.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );
    }
}
