<?php

namespace App\GraphQL\Types;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class OrderType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Order',
        'description' => 'Order type',
        'model' => Order::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Order Id',
            ],
            'order_number' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Order number'
            ],
            'product_count' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Product count',
            ],
            'total_price' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Order price',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'User Id against order',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'user who placed an order',
            ],
        ];
    }

}