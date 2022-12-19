<?php

namespace App\GraphQL\Mutations\Tag;

use App\Models\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateTag',
        'description' => 'Create tag',
    ];

    public function type(): Type
    {
        return GraphQL::type('Tag');
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
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
        ];
    }

    public function resolve($root, array $args): Tag
    {
        $tag = Tag::create($args);
        return $tag;
    }
}