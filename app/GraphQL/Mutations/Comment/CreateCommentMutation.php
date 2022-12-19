<?php

namespace App\GraphQL\Mutations\Comment;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateCommentMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateComment',
        'description' => 'Creates a comment',
    ];

    public function type(): Type
    {
        return GraphQL::type('Comment');
    }

    public function args(): array
    {
        return [
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
        ];
    }

    public function resolve($root, array $args): Comment
    {
        $comment = Comment::create($args);
        return $comment;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'text.required' => 'Text is required',
            'post_id.required' => 'Post Id is required',
            'post_id.exists' => 'Post not found',
        ];
    }
}