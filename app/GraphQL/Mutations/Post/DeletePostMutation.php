<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeletePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePost',
        'description' => 'Delete a post',
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
                'rules' => 'required|exists:posts',
            ],
        ];
    }

    public function resolve($root, array $args): string
    {
        Post::find($args['id'])
             ->delete();

        return 'Post deleted successfully';
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Post not found',
        ];
    }
}