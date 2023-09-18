<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VermittlerUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function get_class;

/**
 * @extends ServiceEntityRepository<VermittlerUser>
 *
 * @method VermittlerUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VermittlerUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VermittlerUser[]    findAll()
 * @method VermittlerUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class VermittlerUserRepository extends ServiceEntityRepository implements UserLoaderInterface, PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VermittlerUser::class);
    }

    public function save(VermittlerUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VermittlerUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    public function loadUserByIdentifier(string $identifier): ?UserInterface
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT vu
                FROM App\Entity\VermittlerUser vu
                LEFT JOIN App\Entity\Vermittler v
                WITH v.id = vu.vermittler
                WHERE vu.email = :email
                AND vu.aktiv = 1
                AND v.geloescht = false'
        )
            ->setParameter('email', $identifier)
            ->getOneOrNullResult();
    }

    /**
     * Upgrades the hashed password of a user, typically for using a better hash algorithm.
     * see https://symfony.com/doc/current/security/passwords.html#security-password-migration
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof VermittlerUser) {
            $class = get_class($user);
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        $user->setPassword($newHashedPassword);

        $this->getEntityManager()->flush();
    }
}
