<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'order_number',
        'product_count',
        'total_price',
        'user_id',
    ];

    public function user(): Relation
    {
        return $this->belongsTo(User::class);
    }

    public function products(): Relation
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($order){
            $order->products()->detach();
        });
    }
}
