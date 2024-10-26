<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Application;

class ListCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered Artisan commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $artisan = $this->getApplication();
        $commands = $artisan->all();

        $this->info('List of all custom Artisan commands:');

        foreach ($commands as $name => $command) {
            $commandNamespace = get_class($command);
            if (str_starts_with($commandNamespace, 'App\Console\Commands')) {
                $this->line($name);
            }
        }

        return 0;
    }
}
