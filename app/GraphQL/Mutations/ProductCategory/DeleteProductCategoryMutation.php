<?php

namespace App\GraphQL\Mutations\ProductCategory;

use App\Models\ProductCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteProductCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteProductCategory',
        'description' => 'Delete product category against given id',
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
                'rules' => 'required|exists:product_categories',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Product category not found',
        ];
    }

    public function resolve($root, array $args): string
    {
        ProductCategory::find($args['id'])
                        ->delete();

        return 'Product category deleted successfully';
    }
}