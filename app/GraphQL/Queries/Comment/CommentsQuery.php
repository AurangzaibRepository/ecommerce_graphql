<?php

namespace App\GraphQL\Queries\Comment;

use App\Models\Comment;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class CommentsQuery extends Query
{
    protected $attributes = [
        'name' => 'CommentsQuery',
        'description' => 'Query to fetch comment(s)',
    ];

    public function type(): Type
    {
        return type::listOf(GraphQL::type('Comment'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:comments',
            ],
            'text' => [
                'name' => 'text',
                'type' => Type::string(),
            ],
            'post_id' => [
                'name' => 'post_id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:posts,id',
            ],
            'page_no' => [
                'name' => 'page_no',
                'type' => Type::int(),
            ],
        ];
    }

    public function resolve($root, array $args)
    {
        if (Arr::exists($args, 'id')) {
            return Comment::where('id', $args['id'])
                           ->get();
        }

        $query = $this->applyFilters($args);
        $limit = config('app.page_size');
        $offset = ($args['page_no'] * $limit) - $limit;

        $data = $query->limit($limit)
                      ->offset($offset)
                      ->get();

        return $data;
    }

    private function applyFilters(array $args): Builder
    {
        $query = Comment::orderBy('id');

        if (Arr::exists($args, 'text')) {
            $query = $query->where('text', 'like', "%{$args['text']}%");
        }

        if (Arr::exists($args, 'post_id')) {
            $query = $query->where('post_id', $args['post_id']);
        }

        return $query;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Comment not found',
            'post_id.exists' => 'Post not found',
        ];
    }
}