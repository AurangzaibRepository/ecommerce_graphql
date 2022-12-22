<?php

namespace App\GraphQL\Mutations\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteProductMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteProduct',
        'description' => 'Delete product',
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => [
                    'required',
                    'exists:products',
                    'unique:order_products,product_id',
                ],
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Product not found',
            'id.unique' => 'Product is associated with order',
        ];
    }

    public function resolve($root, array $args): string
    {
        Product::find($args['id'])
                ->delete();

        return 'Product deleted successfully';
    }
}