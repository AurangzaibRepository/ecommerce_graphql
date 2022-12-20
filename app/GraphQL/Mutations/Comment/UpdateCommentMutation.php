<?php

namespace App\GraphQL\Mutations\Comment;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateCommentMutation extends Mutation
{
    protected $attrbiutes = [
        'name' => 'UpdateComment',
        'description' => 'Update comment',
    ];

    public function type(): Type
    {
        return GraphQL::type('Comment');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:comments',
            ],
            'text' => [
                'name' => 'text',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'post_id' => [
                'name' => 'post_id',
                'type' => Type::int(),
                'rules' => 'required|exists:posts,id',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => 'required|exists:users,id',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'Id is required',
            'id.exists' => 'Comment not found',
            'text.required' => 'Text is required',
            'post_id.required' => 'Post Id is required',
            'post_id.exists' => 'Post not found',
            'user_id.required' => 'User Id is required',
            'user_id.exists' => 'User not found',
        ];
    }

    public function resolve($root, array $args): Comment
    {
        Comment::where('id', $args['id'])
                ->update($args);

        return Comment::find($args['id']);
    }
}