<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteChatMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-chat-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all rows from chat_messages table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('chat_messages')->delete();

        $this->info('All chat messages have been deleted.');
        return Command::SUCCESS;
    }
}
