<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function getFilteredArticles($category = null, $perPage = 10)
    {
        $query = Article::with(['tags', 'user'])
            ->latest();

        if ($category) {
            $query->whereHas('tags', function($q) use ($category) {
                $q->where('name', $category);
            });
        }

        return $query->paginate($perPage);
    }

    public function deleteArticle(Article $article): bool
    {
        return $article->delete();
    }

    public function getAllCategories()
    {
        return \App\Models\Tag::pluck('name')->unique();
    }
}
