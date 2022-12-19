<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'description',
        'image',
        'product_category_id',
    ];

    public function productCategory(): Relation
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
