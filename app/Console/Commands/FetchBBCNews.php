<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\NewsArticleBbcNews;
use Carbon\Carbon;

class FetchBBCNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:bbc-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch BBC News articles from NewsAPI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get(config('services.newsapi.url'), [
            'apiKey' => config('services.newsapi.key'),
            'sources' => 'bbc-news',
            'pageSize' => 100,
            'sortBy' => 'publishedAt',
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];

            foreach ($articles as $article) {
                NewsArticleBbcNews::updateOrCreate(
                    ['url' => $article['url']],
                    [
                        'source' => $article['source']['name'],
                        'author' => $article['author'],
                        'title' => $article['title'],
                        'description' => $article['description'],
                        'image_url' => $article['urlToImage'],
                        'published_at' => Carbon::parse($article['publishedAt']),
                        'content' => $article['content'],
                    ]
                );
            }

            $this->info('Successfully fetched '.count($articles).' articles');
        } else {
            $this->error('Failed to fetch articles: '.$response->status());
        }
    }
}
