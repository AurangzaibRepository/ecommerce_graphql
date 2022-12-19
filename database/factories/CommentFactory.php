<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $postIdList = Post::all()->pluck('id');

        return [
            'text' => $this->faker->text(),
            'post_id' => $this->faker->randomElement($postIdList),
        ];
    }
}
