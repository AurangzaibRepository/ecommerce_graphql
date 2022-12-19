<?php

namespace App\GraphQL\Mutations\ProductCategory;

use App\Models\ProductCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateProductCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateProductCategory',
        'description' => 'Update product category against given id',
    ];

    public function type(): Type
    {
        return GraphQL::type('ProductCategory');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:product_categories',
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
                'rules' => 'required',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Product category not found',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ];
    }

    public function resolve($root, array $args): ProductCategory
    {
        ProductCategory::where('id', $args['id'])
                        ->update($args);

        return ProductCategory::find($args['id']);
    }
}