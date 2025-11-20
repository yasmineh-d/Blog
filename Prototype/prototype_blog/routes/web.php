<?php

use Illuminate\Support\Facades\Route;

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
