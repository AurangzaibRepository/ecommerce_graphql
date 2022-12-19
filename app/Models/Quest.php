<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'description',
        'reward',
        'category_id',
    ];

    public function category(): Relation
    {
        return $this->belongsTo(Category::class);
    }
}
