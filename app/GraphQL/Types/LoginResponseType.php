<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginResponseType extends GraphQLType 
{
    protected $attributes = [
        'name' => 'LoginResponseType',
        'description' => 'Login response type',
    ];

    public function fields(): array
    {
        return [
            'token' => [
                'type' => Type::string(),
                'description' => 'Access token for user',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'User Id',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'user name',
            ],
        ];
    }
}