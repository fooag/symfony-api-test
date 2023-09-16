<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VermittlerUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<VermittlerUser>
 *
 * @method VermittlerUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VermittlerUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VermittlerUser[]    findAll()
 * @method VermittlerUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VermittlerUserRepository extends ServiceEntityRepository implements UserLoaderInterface
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
                WHERE vu.email = :email
                AND vu.aktiv = 1'
        )
            ->setParameter('email', $identifier)
            ->getOneOrNullResult();
    }
}
