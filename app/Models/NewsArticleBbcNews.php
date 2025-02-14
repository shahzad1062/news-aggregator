<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticleBbcNews extends Model
{
    protected $table = 'news_article_bbc_news';

    protected $fillable = [
        'source', 'author', 'title', 'description', 'content', 'url', 'image_url', 'published_at', 'content'
    ];
}
