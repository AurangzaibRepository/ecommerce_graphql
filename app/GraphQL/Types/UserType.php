<?php

namespace App\GraphQL\Types;

use App\Models\User;
use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'User',
        'description' => 'User type',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'User Id',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'user name',
            ],
            'phone_number' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'user phone',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'user email',
            ],
            'profile_picture' => [
                'type' => Type::string(),
                'description' => 'user profile picture',
            ],
            'posts' => [
                'type' => Type::listOf(GraphQL::type('Post')),
                'description' => 'List of user posts',
            ],
            'orders' => [
                'type' => Type::listOf(GraphQL::type('Order')),
                'description' => 'List of orders placed by user',
            ],
        ];
    }

    protected function resolveNameField($root, array $args): string
    {
        return strtoupper($root->name);
    }

    protected function resolveProfilePictureField($root, array $args): string
    {
        return ($root->profile_picture != '' ? url("images/{$root->profile_picture}") : '');
    }
}