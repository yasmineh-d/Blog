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