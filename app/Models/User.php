<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'phone_number',
        'email',
        'profile_picture',
        'password',
        'role',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }

    public function posts(): Relation
    {
        return $this->hasMany(Post::class);
    }

    public function orders(): Relation
    {
        return $this->hasMany(Order::class);
    }

    public function comments(): Relation
    {
        return $this->hasMany(Comment::class);
    }

    public static function boot(): void
    {
        parent::boot();
        self::deleting(function($user){
            $user->posts()->each(function($post){
                $post->delete();
            });

            $user->orders()->each(function($order){
                $order->delete();
            });

            $user->comments()->delete();
        });
    }
}
