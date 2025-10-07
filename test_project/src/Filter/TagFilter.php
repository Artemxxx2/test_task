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
        if (!isset($context['filters']['tagid'])) {
            return;
        }

        $tagId = (int)$context['filters']['tagid'];
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $tagAlias = $queryNameGenerator->generateJoinAlias('tags');
        $parameterName = $queryNameGenerator->generateParameterName('tagId');

        $queryBuilder
            ->innerJoin(sprintf('%s.tags', $rootAlias), $tagAlias)
            ->andWhere(sprintf('%s.id = :%s', $tagAlias, $parameterName))
            ->setParameter($parameterName, $tagId);
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
