<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateSuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@ressapp.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperSecurePassword123!'),
                'is_admin' => 1,
            ]
        );
    }
}
