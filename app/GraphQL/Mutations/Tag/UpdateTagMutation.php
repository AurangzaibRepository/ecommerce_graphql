<?php

namespace App\GraphQL\Mutations\Tag;

use App\Models\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateTag',
        'description' => 'Update tag',
    ];

    public function type(): Type
    {
        return GraphQL::type('Tag');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:tags',
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
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Tag not found',
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
        ];
    }

    public function resolve($root, array $args): Tag
    {
        Tag::where('id', $args['id'])
            ->update($args);

        return Tag::find($args['id']);
    }
}