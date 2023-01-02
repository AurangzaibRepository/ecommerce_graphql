<?php

namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class RoleEnum extends EnumType
{
    protected $attributes = [
        'name' => 'role',
        'description' => 'List of user roles',
        'values' => [
            'Admin' => 'Admin',
            'User' => 'User',
        ],
    ];
}