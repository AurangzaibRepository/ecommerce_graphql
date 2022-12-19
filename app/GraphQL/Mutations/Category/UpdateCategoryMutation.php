<?php

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateCategory',
        'description' => 'Update category',
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(), //Type::nonNull(Type::int())
                'rules' => ['required', 'exists:categories'],
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $category = Category::where('id', $args['id'])
                            ->update($args);

        return Category::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'Category not found',
            'title.required' => 'Title is required',
        ];
    }
}