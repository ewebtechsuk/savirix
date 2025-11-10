<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateLoginToken extends Command
{
    protected $signature = 'user:generate-login-token {email}';
    protected $description = 'Generate a unique login token for a user by email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error('User not found.');
            return 1;
        }
        $token = bin2hex(random_bytes(32));
        $user->login_token = $token;
        $user->save();
        $this->info('Login token generated: ' . $token);
        return 0;
    }
}
