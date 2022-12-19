<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductCategory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $productCategoryIdList = ProductCategory::all()->pluck('id');

        return [
            'name' => $this->faker->title(),
            'description' => $this->faker->text(),
            'product_category_id' => $this->faker->randomElement($productCategoryIdList),
        ];
    }
}
