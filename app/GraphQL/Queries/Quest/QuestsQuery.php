<?php

namespace App\GraphQL\Queries\Quest;

use App\Models\Quest;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class QuestsQuery extends Query
{
    protected $attributes = [
        'name' => 'quests',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Quest'));
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'reward' => [
                'name' => 'reward',
                'type' => Type::int(),
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::int(),
                'rules' => 'exists:categories,id',
            ],
            'page_no' => [
                'name' => 'page_no',
                'type' => Type::int(),
                'rules' => 'required',
            ]
        ];
    }

    public function resolve($root, array $args): Collection
    {
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
        $query = Quest::orderBy('title');

        if (Arr::exists($args, 'title')) {
            $query = $query->where('title', 'like', "%{$args['title']}%");
        }

        if (Arr::exists($args, 'description')) {
            $query = $query->where('description', 'like', "{$args['description']}");
        }

        if (Arr::exists($args, 'reward')) {
            $query = $query->where('reward', $args['reward']);
        }

        if (Arr::exists($args, 'category_id')) {
            $query = $query->where('category_id', $args['category_id']);
        }

        return $query;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'category_id.exists' => 'Category not found',
            'page_no.required' => 'Page number is required',
        ];
    }
}