<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUser',
        'description' => 'Update user',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => 'required|exists:users',
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'phone_number' => [
                'name' => 'phone_number',
                'type' => Type::string(),
                'rules' => 'required',
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => 'required|email',
            ],
        ];
    }

    public function resolve($root, $args): User
    {
        User::where('id', $args['id'])
             ->update($args);

        return User::find($args['id']);
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'User not found',
            'name.required' => 'Name is required',
            'phone_number.required' => 'Phone number is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
        ];
    }
}