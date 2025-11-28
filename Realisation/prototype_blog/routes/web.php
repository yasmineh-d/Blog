<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

// Redirect root to admin articles
Route::get('/', function () {
    return redirect()->route('admin.articles.index');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('articles', AdminArticleController::class);
});