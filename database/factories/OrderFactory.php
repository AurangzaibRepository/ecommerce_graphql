<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {   
        $userIdList = User::all()->pluck('id');

        return [
          'order_no' => "Order_{$this->faker->numberBetween(100, 140)}",
          'product_count' => $this->faker->numberBetween(1,4),
          'total_price' => $this->faker->numberBetween(1000, 2000),
          'user_id' => $this->faker->randomElement($userIdList),
        ];
    }
}
