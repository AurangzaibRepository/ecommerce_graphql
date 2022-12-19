<?php

namespace App\GraphQL\Mutations\Tag;

use App\Models\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteTagMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteTag',
        'description' => 'Delete a tag',
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
                'rules' => 'required|exists:tags',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Tag not found',
        ];
    }

    public function resolve($root, array $args): string
    {
        Tag::find($args['id'])
            ->delete();

        return 'Tag deleted successfully';
    }

}