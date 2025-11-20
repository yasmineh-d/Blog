<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Tag;

class ArticleService
{
    /**
     * Récupère la liste des articles avec :
     * - tri par date la plus récente (latest)
     * - filtre par catégorie (tag)
     * - pagination
     */
    public function getArticles($categoryId = null)
    {
        // Prépare la requête avec relation tags chargée
        $query = Article::with('tags')->latest();

        // Si un filtre par catégorie est appliqué
        if ($categoryId) {
            $query->whereHas('tags', function ($q) use ($categoryId) {
                $q->where('tags.id', $categoryId);
            });
        }

        // Retourne les articles avec pagination (10 par page)
        return $query->paginate(10);
    }

    /**
     * Récupère toutes les catégories (tags)
     * Pour l'affichage du filtre dans la vue Blade
     */
    public function getCategories()
    {
        return Tag::all();
    }
}
