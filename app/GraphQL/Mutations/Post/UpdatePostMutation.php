<?php

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;

class UpdatePostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdatePost',
        'description' => 'Update a post',
    ];

    public function type(): Type
    {
        return GraphQL::type('Post');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:posts',
            ],
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
            'tag_ids' => [
                'name' => 'tag_ids',
                'type' => Type::listOf(Type::int()),
            ],
        ];
    }

    public function resolve($root, array $args): Post
    {
        $post = Post::find($args['id']);
        $post->tags()->detach();

        if(Arr::exists($args, 'tag_ids')) {
            $post->tags()->sync($args['tag_ids']);
            unset($args['tag_ids']);
        }
        
        Post::where('id', $args['id'])
             ->update($args);

        return Post::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Post not found',
            'title.required' => 'Title is required',
            'body.required' => 'Body is required',
            'user_id.required' => 'User Id is required',
            'user_id.exists' => 'User not found',
        ];
    }
}