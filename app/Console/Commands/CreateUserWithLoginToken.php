<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserWithLoginToken extends Command
{
    protected $signature = 'user:create-with-login-token {name} {email} {password}';
    protected $description = 'Create a user with a login token';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $token = bin2hex(random_bytes(32));

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'login_token' => $token,
        ]);

        $this->info('User created. Login token: ' . $token);
        return 0;
    }
}
