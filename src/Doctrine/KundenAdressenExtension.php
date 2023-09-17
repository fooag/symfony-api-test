<?php

declare(strict_types=1);

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Adresse;
use App\Entity\VermittlerUser;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

final class KundenAdressenExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
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
        if (Adresse::class !== $resourceClass) {
            return;
        }

        /** @var VermittlerUser $vermittlerUser */
        $vermittlerUser = $this->security->getUser();

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->leftJoin('App\Entity\KundeAdresse', 'ka', Expr\Join::WITH, sprintf('ka.adresseId = %s.id', $rootAlias));
        $queryBuilder->leftJoin('App\Entity\Kunde', 'ku', Expr\Join::WITH, 'ku.id = ka.kundenId');
        $queryBuilder->andWhere('ka.geloescht = false');
        $queryBuilder->andWhere('ku.vermittlerId = :vermittler_id');
        $queryBuilder->andWhere('ku.geloescht = 0');
        $queryBuilder->setParameter('vermittler_id', $vermittlerUser->getVermittler()->getId());

        //echo $queryBuilder->getQuery()->getSQL(); die;
    }
}