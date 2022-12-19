<?php

namespace App\GraphQL\Queries\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class PostsQuery extends Query
{
    protected $attributes = [
        'name' => 'posts',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Post'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:posts',
            ],
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:users,id',
            ],
            'page_no' => [
                'name' => 'page_no',
                'type' => Type::int(),
                'rules' => 'nullable',
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        if (Arr::exists($args, 'id')) {
            return Post::where('id', $args['id'])
                        ->get();
        }

        $query = $this->applyFilters($args);
        $limit = config('app.page_size');
        $pageNo = (Arr::exists($args, 'page_no') ? $args['page_no'] : 1);
        $offset = ($pageNo * $limit) - $limit;

        return $query->limit($limit)
                     ->offset($offset)
                     ->get();
    }

    private function applyFilters(array $args): Builder
    {
        $query = Post::orderBy('id');

        if (Arr::exists($args, 'title')) {
            $query = $query->where('title', 'like', "%{$args['title']}%");
        }

        if (Arr::exists($args, 'user_id')) {
            $query = $query->where('user_id', $args['user_id']);
        }

        return $query;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Post not found',
            'user_id.exists' => 'User not found',
            'page_no.required' => 'Page number is required',
        ];
    }
}