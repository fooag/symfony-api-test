<?php

namespace App\Doctrine\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Adresse;
use App\Entity\AdresseDetails;
use App\Entity\Kunde;
use App\Entity\Security\UserLogin;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

final class SoftDeleteExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []) : void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }


    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass) : void
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];

        switch ($resourceClass) {
            case Kunde::class:
                // Customer deleted
                $queryBuilder->andWhere(sprintf('%s.geloescht != 1', $rootAlias));
                break;

            case Adresse::class:
                // Address deleted
                $queryBuilder->leftJoin(AdresseDetails::class, 'ad', Expr\Join::WITH, sprintf('ad.adresse = %s.adresseId', $rootAlias));
                $queryBuilder->andWhere('ad.geloescht = false');

                // Customer deleted
                $queryBuilder->leftJoin(Kunde::class, 'k', Expr\Join::WITH, 'ad.kunde = k.id');
                $queryBuilder->andWhere('k.geloescht != 1');

            case UserLogin::class:
                $rootAlias = $queryBuilder->getRootAliases()[0];

                //Customer deleted
                $queryBuilder->leftJoin(Kunde::class, 'k', Expr\Join::WITH, sprintf('k.id = %s.kundenid', $rootAlias));
                $queryBuilder->andWhere('k.geloescht != 1');
                break;
        }
    }


    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []) : void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }
}
