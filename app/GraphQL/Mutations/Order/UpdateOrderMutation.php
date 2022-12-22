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
            'total_price.required' => 'Total price is required',
        ];
    }

    public function resolve($root, array $args): Order
    {
        Order::where('id', $args['id'])
              ->update($args);

        return Order::find($args['id']);
    }
}