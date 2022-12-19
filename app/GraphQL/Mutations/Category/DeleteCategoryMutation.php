<?php

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteCategoryMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteCategory',
        'description' => 'Delete category',
    ];

    public function type(): Type
    {
        return Type::boolean();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:categories'],
            ],
        ];
    }

    public function resolve($root, $args): bool
    {
        Category::find($args['id'])  
                 ->delete();  //Use this model finder to fire delete event defined in category boot method

        return true;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'Category not found',
        ];
    }
}