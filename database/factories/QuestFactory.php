<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Quest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quest>
 */
class QuestFactory extends Factory
{
    protected $model = Quest::class;

    public function definition(): array
    {
        $categoryIdList = Category::all()->pluck('id');

        return [
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'reward' => $this->faker->numberBetween(1, 100),
            'category_id' => $this->faker->randomElement($categoryIdList),
        ];
    }
}
