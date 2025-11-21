<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(Request $request)
    {
        $category = $request->query('category');
        $articles = $this->articleService->getFilteredArticles($category);
        $categories = $this->articleService->getAllCategories();

        return view('articles.index', compact('articles', 'categories', 'category'));
    }


    public function destroy(Article $article)
    {
            $this->articleService->deleteArticle($article);
            return redirect()->route ('articles.index')->with('success','article suprimer avec success');
    }
}
