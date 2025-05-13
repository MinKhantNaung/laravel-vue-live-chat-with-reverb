<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear and cache config, routes, events, and views';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting full optimization...');

        $commands = [
            'optimize:clear',
            'config:clear',
            'event:clear',
            'route:clear',
            'view:clear',

            'optimize',
            'config:cache',
            'event:cache',
            'route:cache',
            'view:cache',
        ];

        foreach ($commands as $command) {
            $this->call($command);
            $this->line("Ran: php artisan $command");
        }

        $this->info('Optimization complete!');
    }
}
