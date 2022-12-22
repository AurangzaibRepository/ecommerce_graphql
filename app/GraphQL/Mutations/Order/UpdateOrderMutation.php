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
            'id.required' => 'Order Id is required',
            'id.exists' => 'Order not found',
            'total_price.required' => 'Total price is required',
            'product_ids.required' => 'Product Ids are required',
        ];
    }

    public function resolve($root, array $args): Order
    {
        $args['product_count'] = count($args['product_ids']);
        $productList = $args['product_ids'];
        unset($args['product_ids']);

        Order::where('id', $args['id'])
              ->update($args);
        
        $order = Order::find($args['id']);
        $order->products()->sync($productList);

        return $order;
    }
}