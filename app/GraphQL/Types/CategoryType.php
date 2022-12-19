<?php

namespace App\GraphQL\Types;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'Collection of categories',
        'model' => Category::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Category Id',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Title of category',
                'resolve' => function($root, array $args) {
                    return strtoupper($root->title);
                }
            ],
            'quests' => [
                'type' => Type::listOf(GraphQL::type('Quest')),
                'description' => 'List of quest',
            ],
            'posts' => [
                'type' => Type::listOf(GraphQL::type('Post')),
                'description' => 'List of post',
            ],
        ];
    }
}