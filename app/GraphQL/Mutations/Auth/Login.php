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
                'rules' => 'required|email',
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'rules' => 'required',
            ],
        ];
    }
}