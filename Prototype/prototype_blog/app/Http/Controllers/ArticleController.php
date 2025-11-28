<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Services\ArticleService;


class ArticleController extends Controller
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService){
        $this->articleService = $articleService;
    }

    public function index(Request $request){
        $categoryId = $request->query('category');
        $data=$this->articleService->getForIndex(perPage:10, categoryId:$categoryId);

        return view('articles.index', $data);
    }

    public function destroy(Article $article){
        $this->articleService->delete($article);
        return redirect()->route('articles.index')->with('success',' Article supprimé avec succés.');
    }
}

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
        try {
            $this->articleService->deleteArticle($article);
            return response()->json(['success' => true, 'message' => 'Article supprimé avec succès.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue lors de la suppression.'], 500);
        }
    }
}
