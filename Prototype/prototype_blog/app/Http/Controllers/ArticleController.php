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

    public function edit(Article $article)
    {
        $categories = \App\Models\Tag::all();
        $article->load('tags');
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        try {
            // Mise à jour des champs de base
            $article->update([
                'title' => $validated['title'],
                'content' => $validated['content']
            ]);

            // Mise à jour des tags
            if (isset($validated['tags'])) {
                $article->tags()->sync($validated['tags']);
            } else {
                $article->tags()->detach();
            }

            return redirect()->route('articles.index')
                ->with('success', 'Article mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
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
