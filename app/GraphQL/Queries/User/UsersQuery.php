<?php

namespace App\GraphQL\Queries\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'nullable|exists:users',
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
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
            return User::where('id', $args['id'])->get();
        }

        $query = $this->applyFilters($args);
        $limit = config('app.page_size');
        $pageNo = (Arr::exists($args, 'page_no') ? $args['page_no'] : 1);
        $offset = ($limit * $pageNo) - $limit;
        
        return $query->limit($limit)
                     ->offset($offset)
                     ->get();
    }

    private function applyFilters(array $args): Builder
    {
        $data = User::orderBy('name');

        if (Arr::exists($args, 'name')) {
            $data = $data->where('name', 'like', "%${args['name']}%");
        }

        if (Arr::exists($args, 'email')) {
            $data = $data->where('email', 'like', "%${args['email']}%");
        }

        return $data;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.exists' => 'User not found',
        ];
    }
}