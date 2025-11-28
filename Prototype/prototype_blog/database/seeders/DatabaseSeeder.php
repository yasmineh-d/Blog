<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $users = User::factory(10)->create();

       $categories = Category::factory(6)->create(); 

      
        $tags = Tag::factory(15)->create();

        $articles = Article::factory(40)->recycle($users)->create();

      foreach ($articles as $article){
        $randomTags = $tags->random(rand(1,4));
        $article->tags()->attach($randomTags);

        $randomCategories = $categories->random(rand(1, 3));
            $article->categories()->attach($randomCategories);
      }
    }
}