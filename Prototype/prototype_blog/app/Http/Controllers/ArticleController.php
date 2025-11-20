<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $service;

    // Injection du ArticleService automatiquement par Laravel
    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    /**
     * Affiche la liste des articles.
     * - Récupère les articles via le service
     * - Récupère les catégories pour le filtre
     * - Envoie les données vers la vue
     */
    public function index(Request $request)
    {
        // Récupère le filtre sélectionné (si existe)
        $categoryId = $request->category;

        // Récupération des articles avec filtre + pagination
        $articles = $this->service->getArticles($categoryId);

        // Récupération des tags pour la liste déroulante
        $categories = $this->service->getCategories();

        // Envoie à la vue
        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Supprime un article.
     * - Supprime dans la BDD
     * - Redirige avec message de succès
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('status', 'Article supprimé avec succès !');
    }
}
