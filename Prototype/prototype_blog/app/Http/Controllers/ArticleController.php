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