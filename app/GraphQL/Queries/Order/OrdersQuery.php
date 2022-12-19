<?php

namespace App\GraphQL\Queries\Order;

use App\Models\Order;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class OrdersQuery extends Query
{
    protected $attributes = [
        'name' => 'OrderQuery',
        'description' => 'Query to fetch orders',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Order'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:orders',
            ],
            'order_number' => [
                'name' => 'order_number',
                'type' => Type::string(),
            ],
            'price' => [
                'name' => 'price',
                'type' => Type::float(),
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:users,id',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'Order not found',
            'user_id.exists' => 'User not found',
        ];
    }

    public function resolve($root, array $args): Collection
    {
        $query = $this->applyFilters($args);
        $limit = config('app.page_size');
        $pageNo = (Arr::exists($args, 'page_no') ? $filters['page_no'] : 1);
        $offset = ($pageNo * $limit) - $limit;

        $data = $query->limit($limit)
                      ->offset($offset)
                      ->get();

        return $data;
    }

    private function applyFilters(array $filters): Builder
    {
        $query = Order::orderBy('id', 'desc');

        if (Arr::exists($filters, 'id')) {
            $query = $query->where('id', $filters['id']);
        }

        if (Arr::exists($filters, 'order_number')) {
            $query = $query->where('order_number', 'like', "%{$filters['order_number']}%");
        }

        if (Arr::exists($filters, 'price')) {
            $query = $query->where('total_price', '>=', $filters['price']);
        }

        if (Arr::exists($filters, 'user_id')) {
            $query = $query->where('user_id', $filters['user_id']);
        }

        return $query;
    }
}