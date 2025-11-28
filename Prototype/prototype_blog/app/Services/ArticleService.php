<?php 

<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;

class ArticleService {
    
    public function getForIndex($perPage = 10, $categoryId = null){
        $categories= Category::orderBy('name')->get();
        $query = Article::with('categories')->orderBy('created_at', 'desc');

        if($categoryId){
            $query->whereHas('categories', function($q) use($categoryId){
                $q->where('categories.id', $categoryId);
            });
        }

        return [
            'articles' => $query->paginate($perPage),
            'categories'=> $categories,
            'selectedCategory'=> $categoryId,
        ];
    }

    public function delete(Article $article) :void{
        $article->delete();
    }
}

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
