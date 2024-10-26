<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user with default email and password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = 'admin@osteriadeitre.com';
        $password = 'Password1!';

        // Check if the user already exists
        $user = User::where('email', $email)->first();

        if ($user) {
            $this->info('User with this email already exists.');
        } else {
            // Create the user
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('Admin user created successfully.');
        }

        return 0;
    }
}
