<?php

namespace App\GraphQL\Mutations\Auth;

use GraphQL\Type\Definiton\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Login extends Mutation
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'Login user',
    ];

    public function type(): Type
    {
        return Type::array();
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
                'rules' => 'required|email|exists:users',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => 'required',
            ],
        ];
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email',
            'email.exists' => 'Email does not exist',
            'password.required' => 'Password is required',
        ];
    }

    public function resolve($root, array $arg): array
    {
        return [
            'ok here',
        ];
    }
}