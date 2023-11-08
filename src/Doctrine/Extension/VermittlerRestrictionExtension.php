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
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\Query\Expr;

final class VermittlerRestrictionExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private Security $security;


    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []) : void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }


    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass) : void
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $user = $this->security->getUser();

        switch ($resourceClass) {
            case Kunde::class:
                $queryBuilder->andWhere(sprintf('%s.vermittlerId = :vermittlerId', $rootAlias));
                $queryBuilder->setParameter('vermittlerId', $user->getVermittler()->getId());
                break;
            case Adresse::class:
                $queryBuilder->leftJoin(AdresseDetails::class, 'ad', Expr\Join::WITH, sprintf('ad.adresse = %s.adresseId', $rootAlias));
                $queryBuilder->leftJoin(Kunde::class, 'k', Expr\Join::WITH, 'ad.kunde = k.id');
                $queryBuilder->andWhere('k.vermittlerId = :vermittlerId');
                $queryBuilder->setParameter('vermittlerId', $user->getVermittler()->getId());
                break;
            case UserLogin::class:
                $queryBuilder->leftJoin(Kunde::class, 'k', Expr\Join::WITH, sprintf('k.id = %s.kunde', $rootAlias));
                $queryBuilder->andWhere('k.vermittlerId = :vermittlerId');
                $queryBuilder->setParameter('vermittlerId', $user->getVermittler()->getId());
                break;
        }
    }


    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []) : void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }
}
