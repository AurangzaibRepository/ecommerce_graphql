<?php

namespace App\GraphQL\Mutations\Order;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateOrder',
        'description' => 'Update order',
    ];

    public function type(): Type
    {
        return GraphQL::type('Order');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:orders',
            ],
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
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Order Id is required',
            'id.exists' => 'Order not found',
            'product_count.required' => 'Product count is required',
            'total_price.required' => 'Total price is required',
        ];
    }
}