<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NYTimesService;

class FetchNYTimesArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:nyt-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest articles from New York Times API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        {
            $service = new NYTimesService();
            $service->fetchArticles();
            $this->info('Successfully fetched and stored NYTimes articles');
        }
    }
}
