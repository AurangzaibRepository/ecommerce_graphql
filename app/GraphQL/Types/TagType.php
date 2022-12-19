<?php

namespace App\GraphQL\Types;

use App\Models\Tag;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TagType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Tag',
        'description' => 'Tag type',
        'model' => Tag::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int(),
                'description' => 'Tag Id',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Tag name',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Tag description',
            ],
        ];
    }
}