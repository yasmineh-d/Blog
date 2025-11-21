<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


// Routes pour les articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');

// Route pour la suppression via AJAX
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])
    ->name('articles.destroy');
