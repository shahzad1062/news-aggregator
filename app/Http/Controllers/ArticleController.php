<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::orderBy('publication_date', 'desc')->paginate(10);
    }
}
