<?php

namespace App\GraphQL\Mutations\ProductCategory;

use App\Models\ProductCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateProductCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateProductCategory',
        'description' => 'Create product category',
    ];

    public function type(): Type
    {
        return GraphQL::type('ProductCategory');
    }

    public function args(): array
    {
        return [
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
            'title.required' => 'Title is required',
            'descripton.required' => 'Description is required',
        ];
    }

    public function resolve($root, array $args=[]): ProductCategory
    {
        $productCategory = ProductCategory::create($args);

        return $productCategory;
    }
}