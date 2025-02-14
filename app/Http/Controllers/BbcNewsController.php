<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsArticleBbcNews;

class BbcNewsController extends Controller
{
    public function index()
    {
        return NewsArticleBbcNews::orderBy('published_at', 'desc')
            ->paginate(10);
    }

    public function show($id)
    {
        return NewsArticleBbcNews::findOrFail($id);
    }
}
