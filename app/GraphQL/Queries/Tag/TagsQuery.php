<?php

namespace App\GraphQL\Queries\Tag;

use App\Models\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class TagsQuery extends Query
{
    protected $attributes = [
        'name' => 'TagQuery',
        'description' => 'Tag query',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Tag'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:tags',
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'page_no' => [
                'name' => 'page_no',
                'type' => Type::int(),
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Tag not found',
        ];
    }

    public function resolve($root, array $args): Collection
    {
        $query = $this->applyFilters($args);
        $limit = config('app.page_size');
        $pageNo = (Arr::exists($args, 'page_no') ? $args['page_no'] : 1);
        $offset = ($pageNo * $limit) - $limit;

        $data = $query->limit($limit)
                      ->offset($offset)
                      ->get();

        return $data;
    }

    private function applyFilters(array $filters): Builder
    {
        $query = Tag::orderBy('id');

        if (Arr::exists($filters, 'id')) {
            $query = $query->where('id', $filters['id']);
        }

        if (Arr::exists($filters, 'name')) {
            $query = $query->where('name', 'like', "%{$filters['name']}%");
        }

        if (Arr::exists($filters, 'description')) {
            $query = $query->where('description', 'like', "%{$filters['description']}%");
        }

        return $query;
    }
}