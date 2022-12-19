<?php

namespace App\GraphQL\Queries\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CategoryQuery extends Query 
{
    protected $attributes = [
        'name' => 'category',
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
                'type' => Type::int(),
                'rules' => ['required'],
            ]
        ];
    }

    public function resolve($root, $args) 
    {
        return Category::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'CategoryId is required',
        ];
    }
}