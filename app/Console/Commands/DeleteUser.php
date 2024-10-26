<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user';

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
            $this->info("{$index}. Username: {$user->name}, Email: {$user->email}");
        }

        $userIndex = $this->ask('Enter the number of the user you want to delete');

        if (!is_numeric($userIndex) || !isset($users[$userIndex])) {
            $this->error('Invalid user number.');
            return 1;
        }

        $user = $users[$userIndex];

        if ($this->confirm("Are you sure you want to delete user {$user->username} (ID: {$user->id})?")) {
            $user->delete();
            $this->info("User {$user->username} deleted successfully.");
            return 0;
        }

        $this->info('Operation cancelled.');
        return 0;
    }
}
