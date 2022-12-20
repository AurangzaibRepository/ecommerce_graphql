<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
    ];

    public function posts(): Relation
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}
