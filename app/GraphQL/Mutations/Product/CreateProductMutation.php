<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateProduct',
        'description' => 'Create a product',
    ];

    public function type(): Type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'product_category_id' => [
                'name' => 'product_category_id',
                'type' => Type::int(),
                'rules' => 'required|exists:product_categories,id',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
            'product_category_id.required' => 'Product category Id is required',
            'product_category_id.exists' => 'Product category not found',
        ];
    }

    public function resolve($root, array $args): Product
    {
        $product = Product::create($args);
        return $product;
    }
}