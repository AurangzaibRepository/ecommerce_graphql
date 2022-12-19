<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteUser',
        'description' => 'Delete user',
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required', 'exists:users'],
            ],
        ];
    }

    public function resolve($root, $args): string
    {
        //User::where('id', $args['id'])
             //->delete();
        User::find($args['id'])
             ->delete(); // Use eloquent delete function to trigger delete event in user boot function

        return "User deleted successfully";
    }

    public function validationErrorMessages(array $args=[]): array
    {
        return [
            'id.required' => 'ID is required',
            'id.exists' => 'User not found',
        ];
    }
}