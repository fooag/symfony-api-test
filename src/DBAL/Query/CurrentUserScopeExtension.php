<?php

declare(strict_types=1);

namespace App\DBAL\Query;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * cf. https://api-platform.com/docs/core/extensions/#custom-doctrine-orm-extension
 */
final class CurrentUserScopeExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var CurrentUserScopeFactory
     */
    private $userScopeFactory;

    public function __construct(Security $security, CurrentUserScopeFactory $userScopeFactory)
    {
        $this->security = $security;
        $this->userScopeFactory = $userScopeFactory;
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        string $operationName = null,
        array $context = []
    ): void {
        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        $user = $this->security->getUser();
        if ($user instanceof UserInterface === false) {
            return;
        }

        $rootAlias = $queryBuilder->getRootAliases()[0];

        $this->userScopeFactory
            ->resolveScopeForContext($user, $resourceClass)
            ->addWhere($queryBuilder, $rootAlias, $user);
    }
}
