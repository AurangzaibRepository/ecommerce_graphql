<?php

namespace App\GraphQL\Mutations\Comment;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteCommentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteComment',
        'description' => 'Delete a comment',
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
                'rules' => 'required|exists:comments',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Comment not found',
        ];
    }

    public function resolve($root, array $args): string
    {
        Comment::find($args['id'])
                ->delete();

        return 'Comment deleted successfully';
    }
}