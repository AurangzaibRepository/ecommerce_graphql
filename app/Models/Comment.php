<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $fillable = [
        'text',
        'post_id',
        'user_id',
    ];

    public function post(): Relation
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }
}
