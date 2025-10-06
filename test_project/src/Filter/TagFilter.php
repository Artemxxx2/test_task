<?php

namespace App\Filter;

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;

final class TagFilter implements FilterInterface
{
    public function apply(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        dd('test');
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'tagid' => [
                'property' => 'tagId',
                'type' => 'int',
                'required' => false,
                'description' => 'Filter by tag ID',
                'openapi' => [
                    'example' => 123,
                    'allowReserved' => false,
                    'allowEmptyValue' => true,
                    'explode' => false,
                ],
                'schema' => [
                    'type' => 'integer',
                ]
            ],
        ];
    }
}
