<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreatePostMutation extends Mutation 
{
    protected $attributes = [
        'name' => 'CreatePost',
        'description' => 'create a post',
    ];

    public function type(): Type 
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'body' => [
                'name' => 'body',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => 'required|exists:users,id',
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::int(),
                'rules' => 'required|exists:categories,id',
            ],
            'tag_ids' => [
                'name' => 'tag_ids',
                'type' => Type::listOf(Type::int()),
            ],
        ];
    }

    public function resolve($root, array $args): Post
    {
        $post = Post::create($args);
        return $post;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
            'user_id.required' => 'User Id is required',
            'user_id.exists' => 'User not found',
            'category_id.required' => 'Category Id is required',
            'category_id.exists' => 'Category not found',
        ];
    }

}