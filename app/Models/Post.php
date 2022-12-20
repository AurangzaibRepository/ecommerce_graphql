<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'body',
        'image',
        'user_id',
        'category_id',
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function category(): Relation
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): Relation
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): Relation
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($post){
            $post->comments()->each(function($comment){
                $comment->delete();
            });
        });

    }
}
