<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controllers;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles', [Controllers\ArticleController::class, 'index']);

Route::get('/bbc-news', [Controllers\BbcNewsController::class, 'index']);
