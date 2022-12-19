<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $fillable = ['title'];

    public function quests(): Relation
    {
        return $this->hasMany(Quest::class);
    }

    public function posts(): Relation
    {
        return $this->hasMany(Post::class);
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($category) {
            $category->quests()->each(function($quest){
                $quest->delete();
            });

            $category->posts()->each(function($post){
                $post->delete();
            });
        });
    }
}
