<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateUser',
        'description' => 'Create user',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function args(): array
    {
        return [
            'name' => [
                'name' => 'name',
                'type' => Type::string(), //Type::nonNull(Type::string())
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
            'profile_picture' => [
                'name' => 'profile_picture',
                'type' => GraphQL::type('Upload'),
                //'rules' => ['required', 'image'],
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => 'required',
            ],
        ];
    }

    public function resolve($root, array $args): User
    {
        $user = User::create($args);
        return $user;
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'name.required' => 'Name is required',
            'phone_number.required' => 'Phone number is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
        ];
    }
}