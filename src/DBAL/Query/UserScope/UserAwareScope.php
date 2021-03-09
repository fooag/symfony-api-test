<?php

declare(strict_types=1);

namespace App\DBAL\Query\UserScope;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserAwareScope
{
    public function addWhere(QueryBuilder $queryBuilder, string $rootAlias, UserInterface $currentUser): void;
}
