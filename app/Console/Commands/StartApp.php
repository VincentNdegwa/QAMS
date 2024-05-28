<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StartApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start this commant to intitiate server start and queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serve = new Process(['php', 'artisan', 'serve']);
        $queue = new Process(['php', 'artisan', 'queue:work']);

        $serve->start();
        $serve->setTimeout(null);
        $this->info("Starting the server...");


        $queue->start();
        $queue->setTimeout(null);
        $this->info('Running the queue...');

        foreach ($serve as $type => $data) {
            $this->output->write($serve);
        }



        foreach ($queue as $type => $data) {
            $this->output->write($queue);
        }
        if (!$serve->isRunning()) {
            $this->error('serve process has stopped!!');
        }
        if (!$queue->isRunning()) {
            $this->error('queue process has stopped!!');
        }
    }
}
