<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateProduct',
        'description' => 'Update a product',
    ];

    public function type(): type
    {
        return GraphQL::type('Product');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:products',
            ],
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
            'price' => [
                'name' => 'price',
                'type' => Type::float(),
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
            'id.required' => 'Id is required',
            'id.exists' => 'Product not found',
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'product_category_id.required' => 'Product category id is required',
            'product_category_id.exists' => 'Product category not found',
        ];
    }

    public function resolve($root, array $args): Product
    {
        Product::where('id', $args['id'])
                ->update($args);

        return Product::find($args['id']);
    }
}