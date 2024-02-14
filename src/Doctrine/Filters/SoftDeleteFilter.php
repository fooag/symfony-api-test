<?php

declare(strict_types=1);

namespace App\Doctrine\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class SoftDeleteFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if (!$targetEntity->reflClass->hasProperty('geloescht')) {
            return "";
        }

        $propertyType = $targetEntity->reflClass->getProperty('geloescht')->getType()->getName();

        return match ($propertyType) {
            'int' => $targetTableAlias . '.geloescht = 0',
            'bool' => $targetTableAlias . '.geloescht = true',
            default => "",
        };
    }
}