<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the password of a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all(['id', 'name', 'email']);

        if ($users->isEmpty()) {
            $this->info('No users found.');
            return 0;
        }

        $this->info('List of users:');
        foreach ($users as $index => $user) {
            $this->info("{$index}. Username: {$user->username}, Email: {$user->email}");
        }

        $userIndex = $this->ask('Enter the number of the user whose password you want to change');

        if (!is_numeric($userIndex) || !isset($users[$userIndex])) {
            $this->error('Invalid user number.');
            return 1;
        }

        $user = $users[$userIndex];

        $newPassword = $this->secret('Enter the new password');
        $confirmPassword = $this->secret('Confirm the new password');

        if ($newPassword !== $confirmPassword) {
            $this->error('Passwords do not match.');
            return 1;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info("Password for user {$user->username} changed successfully.");
        return 0;
    }
}
