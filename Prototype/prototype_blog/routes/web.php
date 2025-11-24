<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


// Routes pour les articles
Route::resource('/articles', ArticleController::class)->except(['show']);

// Route pour la suppression via AJAX
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])
    ->name('articles.destroy');
