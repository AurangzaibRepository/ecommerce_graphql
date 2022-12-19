<?php

namespace App\GraphQL\Queries\ProductCategory;

use App\Models\ProductCategory;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductCategoriesquery extends Query
{
    protected $attributes = [
        'name' => 'ProductCategoriesQuery',
        'description' => 'Query to fetch product categories',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('ProductCategory'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:product_categories',
            ],
            'title' => [
                'name' => 'title',
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
            'id.exists' => 'Product category not found',
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
        $query = ProductCategory::orderBy('id');

        if (Arr::exists($filters, 'id')) {
            $query = $query->where('id', $filters['id']);
        }

        if (Arr::exists($filters, 'title')) {
            $query = $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (Arr::exists($filters, 'description')) {
            $query = $query->where('description', 'like', "%{$filters['description']}%");
        }

        return $query;
    }
}