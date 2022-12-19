<?php

namespace App\GraphQL\Types;

use App\Models\ProductCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProductCategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'ProductCategory',
        'description' => 'Product categories',
        'model' => ProductCategory::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Product category Id',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Product category title',
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Product category description',
            ],
            'products' => [
                'type' => Type::listOf(GraphQL::type('Product')),
                'description' => 'list of products under category',
            ],
        ];
    }
}