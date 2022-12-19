<?php

namespace App\GraphQL\Mutations\Quest;

use App\Models\Quest;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateQuestMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateQuest',
        'description' => 'Update quest',
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
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
            'reward' => [
                'name' => 'reward',
                'type' => Type::int(),
                'rules' => ['required'],
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:categories,id'],
            ],
        ];
    }

    public function resolve($root, $args): Quest
    {
        Quest::where('id', $args['id'])
                       ->update($args);

        return Quest::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'Quest not found',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'reward.required' => 'Reward is required',
            'category_id.required' => 'CategoryId is required',
            'category_id.exists' => 'Category not found',
        ];
    }
}