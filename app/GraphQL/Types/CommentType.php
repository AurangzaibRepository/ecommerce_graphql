<?php

namespace App\GraphQL\Types;

use App\Models\Comments;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CommentType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Comment',
        'description' => 'Collection of comments against postid',
        'model' => Comment::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Comment Id',
            ],
            'text' => [
                'type' => Type::string(),
                'description' => 'Comment text',
            ],
            'post' => [
                'type' => GraphQL::type('Post'),
                'description' => 'Post against comment',
            ],
            'user' => [
                'type' => GraphQL::type('User'),
                'description' => 'User who posted comment',
            ],
        ];
    }
}