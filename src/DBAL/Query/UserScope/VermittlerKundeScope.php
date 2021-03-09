<?php

declare(strict_types=1);

namespace App\DBAL\Query\UserScope;

use App\Entity\VermittlerUser;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;

class VermittlerKundeScope implements UserAwareScope
{
    public function addWhere(QueryBuilder $queryBuilder, string $rootAlias, UserInterface $currentUser): void
    {
        if ($currentUser instanceof VermittlerUser === false) {
            throw new \RuntimeException('Unsupported user type: ' . get_class($currentUser));
        }

        $queryBuilder->andWhere($rootAlias . '.vermittler = :currentUserId');
        $queryBuilder->setParameter('currentUserId', $currentUser->getVermittler()->getId());
    }
}
