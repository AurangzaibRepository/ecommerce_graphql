<?php

namespace App\GraphQL\Queries\Product;

use App\Models\Product;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ProductsQuery extends Query
{
    protected $attributes = [
        'name' => 'ProductQuery',
        'description' => 'Query to fetch products',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Product'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:products',
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
            ],
            'product_category_id' => [
                'name' => 'product_category_id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:product_categories,id',
            ],
            'page_no' => [
                'name' => 'page_no',
                'type' => Type::int(),
            ],
        ];
    }

    public function valdiationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Product not found',
            'product_category_id.exists' => 'Product category not found',
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
        $query = Product::orderBy('id');

        if (Arr::exists($filters, 'id')) {
            $query = $query->where('id', $filters['id']);
        }

        if (Arr::exists($filters, 'name')) {
            $query = $query->where('name', 'like', "%{$filters['name']}%");
        }

        if (Arr::exists($filters, 'description')) {
            $query = $query->where('description', 'like', "%{$filters['description']}%");
        }

        if (Arr::exists($filters, 'product_category_id')) {
            $query = $query->where('product_category_id', $filters['product_category_id']);
        }

        return $query;
    }
}