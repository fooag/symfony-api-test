<?php

declare(strict_types=1);

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Adresse;
use App\Entity\Kunde;
use App\Entity\KundeAdresse;
use App\Entity\User;
use App\Entity\VermittlerUser;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

final class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private readonly Security $security)
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        /** @var VermittlerUser $loggedInUser */
        $loggedInUser = $this->security->getUser();

        // see https://api-platform.com/docs/core/extensions/
        switch ($resourceClass) {
            case Adresse::class === $resourceClass:
                $rootAlias = $queryBuilder->getRootAliases()[0];
                $queryBuilder->leftJoin('App\Entity\KundeAdresse', 'ka', Expr\Join::WITH, sprintf('ka.adresseId = %s.id', $rootAlias));
                $queryBuilder->leftJoin('App\Entity\Kunde', 'ku', Expr\Join::WITH, 'ku.id = ka.kundenId');
                $queryBuilder->andWhere('ka.geloescht = false');
                $queryBuilder->andWhere('ku.vermittlerId = :vermittler_id');
                $queryBuilder->andWhere('ku.geloescht IS NULL OR ku.geloescht = 0');
                $queryBuilder->setParameter('vermittler_id', $loggedInUser->getVermittler()->getId());
                break;
            case Kunde::class === $resourceClass:
                $rootAlias = $queryBuilder->getRootAliases()[0];
                $queryBuilder->leftJoin('App\Entity\Vermittler', 'v', Expr\Join::WITH, sprintf('v.id = %s.vermittlerId', $rootAlias));
                $queryBuilder->andWhere('v.id = :vermittler_id');
                $queryBuilder->andWhere(sprintf('%s.geloescht IS NULL OR %s.geloescht = 0', $rootAlias, $rootAlias));
                $queryBuilder->setParameter('vermittler_id', $loggedInUser->getVermittler()->getId());
                break;
            case User::class === $resourceClass:
                $rootAlias = $queryBuilder->getRootAliases()[0];
                $queryBuilder->leftJoin('App\Entity\Kunde', 'ku', Expr\Join::WITH, sprintf('ku.id = %s.kundenid', $rootAlias));
                $queryBuilder->andWhere('ku.geloescht IS NULL OR ku.geloescht = 0');
                $queryBuilder->andWhere('ku.vermittlerId = :vermittler_id');
                $queryBuilder->setParameter('vermittler_id', $loggedInUser->getVermittler()->getId());
                break;
        }
    }
}