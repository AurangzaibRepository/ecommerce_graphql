<?php

namespace App\GraphQL\Mutations\Quest;

use App\Models\Quest;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteQuestMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteQuest',
        'description' => 'Delete quest',
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
                'rules' => ['required', 'exists:quests'],
            ],
        ];
    }

    public function resolve($root, $args)
    {
        Quest::where('id', $args['id'])
              ->delete();
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'Quest not found',
        ];
    }
}