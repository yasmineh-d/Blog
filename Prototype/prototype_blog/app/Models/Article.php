<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    
    protected $fillable= [
        'user_id', 'title', 'slug', 'excrept', 'content'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    public function categories()
    {
    return $this->belongsToMany(Category::class, 'article_category');
    }
}

    // Mass assignable attributes
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
        // Un article appartient à un utilisateur
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
        // Un article peut avoir plusieurs tags (et vice versa)
        // Laravel utilise automatiquement la table article_tag
    }
}
