<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Instance;
use App\Jobs\InstanceNodeinfo;

class FetchNodeinfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-nodeinfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Instance::whereNotNull('first_seen_at')
            ->whereIn('crawl_state', [4, 10, 11, 12, 20])
            ->where(function($q) {
                return $q->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', now()->subHours(6));
            })
            ->count();

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach(
            Instance::whereNotNull('first_seen_at')
            ->whereIn('crawl_state', [4, 10, 11, 12, 20])
            ->where(function($q) {
                return $q->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', now()->subHours(6));
            })->lazy() as $instance
        ) {
            InstanceNodeinfo::dispatch($instance)->onQueue('nodeinfo');
            $bar->advance();
        }
        $bar->finish();
        $this->line(' ');
    }
}
