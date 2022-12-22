<?php

namespace App\GraphQL\Types;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ProductType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Product',
        'description' => 'Product type',
        'model' => Product::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
              'type' => Type::nonNull(Type::int()),
              'description' => 'Product Id',
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Product name',
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Product description',
            ],
            'price' => [
                'type' => Type::nonNull(Type::float()),
                'description' => 'Product price',
            ],
            'product_category_id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Product category id',
            ],
            'image' => [
                'type' => Type::string(),
                'description' => 'Product image',
            ],
            'productCategory' => [
                'type' => GraphQL::type('ProductCategory'),
                'description' => 'Product category',
            ],
            'orders' => [
                'type' => Type::listOf(GraphQL::type('Order')),
                'description' => 'Orders associated with product',
            ],
        ];
    }

    public function resolveImageField($root, array $args): string|null
    {
        return ($root->image ? url("/images/{$root->image}") : null);
    }
}