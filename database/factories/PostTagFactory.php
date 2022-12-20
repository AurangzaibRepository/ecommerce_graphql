<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\Tag;
use App\Models\PostTag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostTag>
 */
class PostTagFactory extends Factory
{
    protected $model = PostTag::class;

    public function definition()
    {
        $postIdList = Post::all()->pluck('id');
        $tagIdList = Tag::all()->pluck('id');

        return [
            'post_id' => $this->faker->randomElement($postIdList),
            'tag_id' => $this->faker->randomElement($tagIdList),
        ];
    }
}
