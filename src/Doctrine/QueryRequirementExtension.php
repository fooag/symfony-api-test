<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Adresse;
use App\Entity\Kunde;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

final class QueryRequirementExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Security $security, LoggerInterface $logger)
    {
        $this->security = $security;
        $this->logger = $logger;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $this->logger->critical(print_r($queryBuilder->getAllAliases(), true));

        if ($resourceClass !== Adresse::class) {
            $queryBuilder->andWhere(sprintf('%s.geloescht != 1', $rootAlias));
        }

        $user = $this->security->getUser();

        if ($user === null) {
            return;
        }

        if (!$user instanceof User) {
            return;
        }

        if ($resourceClass === Kunde::class) {
            $this->addKundeWhere($queryBuilder, $rootAlias, $user);
        }

        if ($resourceClass === Adresse::class) {
            $this->addAddressWhere($queryBuilder, $rootAlias, $user);
        }
    }

    private function addKundeWhere(QueryBuilder $queryBuilder, string $rootAlias, User $currentUser)
    {
        $id = $currentUser->getVermittler()->getId();

        $queryBuilder->andWhere(sprintf('%s.vermittler_id = :current_user', $rootAlias));
        $queryBuilder->setParameter('current_user', $id);
    }

    private function addAddressWhere(QueryBuilder $queryBuilder, string $rootAlias, User $currentUser)
    {
        $queryBuilder->innerJoin($rootAlias . '.kunde', 'a');
        $queryBuilder->innerJoin( 'a.vermittler', 'v');
        $queryBuilder->andWhere('v.id = :current_user');
        $queryBuilder->setParameter('current_user', $currentUser->getVermittler()->getId());
    }
}
