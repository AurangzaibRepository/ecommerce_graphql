<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        $orderIdList = Order::all()->pluck('id');
        $productIdList = Product::all()->pluck('id');

        return [
            'order_id' => $this->faker->randomElement($orderIdList),
            'product_id' => $this->faker->randomElement($productIdList),
        ];
    }
}
