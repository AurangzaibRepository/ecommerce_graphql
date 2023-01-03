<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class Login extends Mutation
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'Login user',
    ];

    public function type(): Type
    {
        return GraphQL::type('LoginResponseType');
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

    public function resolve($root, array $args): array
    {
        $user = User::where('email', $args['email'])->first();

        if (!Hash::check($args['password'], $user->password)){
           throw ValidationException::withMessages([
            'error' => 'Invalid credentials',
           ]);
        }

        $token = Str::random(60);
        $user->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return [
            'token' => $token,
            'user_id' => $user->id,
            'user_name' => $user->name,
        ];
    }
}