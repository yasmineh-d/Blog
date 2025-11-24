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

    public function updateArticle(Article $article, array $data)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Mise à jour des champs de base
            $updateData = [
                'title' => $data['title'],
                'content' => $data['content'],
                'updated_at' => now(),
            ];

            // Mise à jour de la date de création si fournie
            if (!empty($data['created_at'])) {
                $updateData['created_at'] = $data['created_at'];
            }

            $article->update($updateData);

            // Mise à jour des tags
            if (isset($data['tags'])) {
                $tagIds = [];
                foreach ($data['tags'] as $tagName) {
                    $tag = \App\Models\Tag::firstOrCreate(['name' => $tagName]);
                    $tagIds[] = $tag->id;
                }
                $article->tags()->sync($tagIds);
            }

            \Illuminate\Support\Facades\DB::commit();
            return $article;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            throw $e;
        }
    }
}
