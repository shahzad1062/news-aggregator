<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Article;
use Carbon\Carbon;

class FetchGuardianArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:guardian-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest articles from The Guardian';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(config('services.guardian.url'), [
            'api-key' => config('services.guardian.key'),
            'show-fields' => 'body',
            'page-size' => 200,
            'order-by' => 'newest',
        ]);

        if ($response->successful()) {
            $articles = $response->json()['response']['results'];

            foreach ($articles as $article) {
                Article::updateOrCreate(
                    [
                        'title' => $article['webTitle'],
                        'section' => $article['sectionName'],
                        'publication_date' => Carbon::parse($article['webPublicationDate']),
                        'url' => $article['webUrl'],
                        'content' => $article['fields']['body'] ?? null,
                    ]
                );
            }

            $this->info('Successfully fetched '.count($articles).' articles');
        } else {
            $this->error('Failed to fetch articles: '.$response->status());
        }
    }
}
