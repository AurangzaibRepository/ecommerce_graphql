<?php

namespace App\GraphQL\Queries\Quest;

use App\Models\Quest;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class QuestQuery extends Query
{
    protected $attributes = [
        'name' => 'quest',
    ];

    public function type(): Type
    {
        return GraphQL::type('Quest');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return Quest::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'QuestId is required',
        ];
    }
}