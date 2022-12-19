<?php

namespace App\GraphQL\Types;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Post',
        'description' => 'Collection of posts against user',
        'model' => Post::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Post Id',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Post title',
            ],
            'body' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Post body',
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'Post image',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'Post user',
            ],
            'category' => [
                'type' => GraphQL::type('Category'),
                'description' => 'Post category',
            ],
            'comments' => [
                'type' => Type::listOf(GraphQL::type('Comment')),
            ],
        ];
    }

    public function resolveImageField($root, array $args): string|null
    {
        return ($root->image ? url("images/{$root->image}") : null);
    }
}