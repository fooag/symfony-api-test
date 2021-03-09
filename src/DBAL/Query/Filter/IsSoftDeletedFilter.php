<?php

declare(strict_types=1);

namespace App\DBAL\Query\Filter;

use App\Entity\SoftDeletable;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class IsSoftDeletedFilter extends SQLFilter
{
    private const SOFT_DELETE_COLUMN = 'geloescht';

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        // Check if the entity implements the SoftDeletable interface
        if (!$targetEntity->reflClass->implementsInterface(SoftDeletable::class)) {
            return '';
        }

        return sprintf(
            'CAST(%s as int)=0',
            $targetTableAlias . '.' . self::SOFT_DELETE_COLUMN
        );
    }
}
