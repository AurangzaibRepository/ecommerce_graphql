<?php

namespace App\GraphQL\Mutations\Order;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteOrderMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteOrder',
        'description' => 'Delete order',
    ];

    public function type(): Type
    {
        return Type::string();
    }
}