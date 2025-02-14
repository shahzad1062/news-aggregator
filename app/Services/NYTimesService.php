<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class NYTimesService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.nyt.key');
        $this->baseUrl = config('services.nyt.url');
    }

    public function fetchArticles()
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'api-key' => $this->apiKey,
                    'sort' => 'newest',
                    'fl' => 'headline,snippet,web_url,pub_date,keywords'
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $this->storeArticles($data['response']['docs']);

        } catch (\Exception $e) {
            Log::error('NYTimes API Error: ' . $e->getMessage());
        }
    }

    protected function storeArticles(array $articles)
    {
        foreach ($articles as $articleData) {
            try {
                \App\Models\Article::updateOrCreate(
                    ['web_url' => $articleData['web_url']],
                    [
                        'headline' => $articleData['headline']['main'],
                        'snippet' => $articleData['snippet'],
                        'pub_date' => $articleData['pub_date'],
                        'source' => 'New York Times',
                        'keywords' => $articleData['keywords']
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Article Save Error: ' . $e->getMessage());
            }
        }
    }
}