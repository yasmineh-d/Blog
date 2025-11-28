<?php

use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); // Assuming this exists or will exist
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store'); // Assuming this exists or will exist
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit'); // Assuming this exists or will exist
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update'); // Assuming this exists or will exist
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;


// Routes pour les articles
Route::resource('/articles', ArticleController::class)->except(['show']);

// Route pour la suppression via AJAX
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])
    ->name('articles.destroy');
