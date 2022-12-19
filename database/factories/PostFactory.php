<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $userList = User::all()->pluck('id');

        return [
            'title' => $this->faker->title(),
            'body' => $this->faker->text(),
            'user_id' => $this->faker->randomElement($userList),
        ];
    }
}
