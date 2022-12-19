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
            'product_count' => [
                'name' => 'product_count',
                'type' => Type::int(),
                'rules' => 'required',
            ],
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
        ];
    }
}