<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialFeedSyncService;

class SyncSocialFeedsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'social:sync';

    /**
     * The console command description.
     */
    protected $description = 'Automatically fetch and sync the latest 5 posts from Textiles Committee social media accounts (YouTube, X, Facebook, Instagram)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting Social Media Feed Sync for Textiles Committee...");

        $results = SocialFeedSyncService::syncAll();

        $this->info("Sync completed successfully!");
        $this->table(['Platform', 'Posts Synced / Active'], [
            ['YouTube', $results['youtube']],
            ['X (Twitter)', $results['twitter']],
            ['Facebook', $results['facebook']],
            ['Instagram', $results['instagram']],
        ]);

        return Command::SUCCESS;
    }
}
