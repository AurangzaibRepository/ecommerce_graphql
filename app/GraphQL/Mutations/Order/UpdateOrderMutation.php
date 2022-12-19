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
}