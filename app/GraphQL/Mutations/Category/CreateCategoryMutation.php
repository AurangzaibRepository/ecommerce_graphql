<?php

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateCategory',
        'description' => 'Create category',
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => 'required',
            ],
        ];
    }

    public function resolve($root, $args): Category
    {
        $category = Category::create($args);
        return $category;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'title.required' => 'Title is required',
        ];
    }
}