<?php

namespace App\GraphQL\Mutations\Order;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateOrder',
        'description' => 'Create order',
    ];

    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    public function args(): array
    {
        return [
            'total_price' => [
                'name' => 'total_price',
                'type' => Type::float(),
                'rules' => 'required',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => 'required|exists:users,id',
            ],
            'product_ids' => [
                'name' => 'product_ids',
                'type' => Type::listOf(Type::int()),
                'rules' => 'required',
            ],

        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'total_price.required' => 'Total price is required',
            'user_id.required' => 'User Id is required',
            'user_id.exists' => 'User not found',
            'product_ids.required' => 'Product Ids are required',
        ];
    }

    public function resolve($root, array $args): Order
    {
        $args['order_number'] = $this->generateOrderNumber();
        $order = Order::create($args);

        return $order;
    }

    private function generateOrderNumber(): string
    {
        $orderCount = Order::count() + 1;
        return "Order_{$orderCount}";
    }
}