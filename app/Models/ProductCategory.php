<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'description',
    ];

    public function products(): Relation
    {
        return $this->hasMany(Product::class);
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($productCategory){
            $productCategory->products()->each(function($product){
                $product->delete();
            });
        });
    }
}
