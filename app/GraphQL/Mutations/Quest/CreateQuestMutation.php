<?php

namespace App\GraphQL\Mutations\Quest;

use App\Models\Quest;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateQuestMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateQuest',
        'description' => 'Create quest',
    ];

    public function type(): Type
    {
        return GraphQL::type('Quest');
    }

    public function args(): array
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string(), //Type::nonNull(Type::string())
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
        $quest = Quest::create($args);
        return $quest;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'reward.required' => 'Reward is required',
            'category_id.required' => 'CategoryId is required',
            'category_id.exists' => 'Category not found',
        ];
    }
}