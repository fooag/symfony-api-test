<?php

namespace App\Repository;

use App\Entity\Kunden;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Kunden[] Returns an array of Kunden objects
     */
    public function findByVermittleId(string $vermittlerId): array
    {
        return $this->createQueryBuilder('u')
            ->leftjoin('u.kundenid', 'k')
            ->andWhere('k.vermittler = :vermittlerId')
            ->andWhere('k.geloescht != :del')
            ->setParameter('vermittlerId', $vermittlerId)
            ->setParameter('del', 1)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @param string $id
     * @param string $vermittlerId
     * @return User
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByIdVermittleId(string $id, string $vermittlerId): User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.kundenid', 'k')
            ->andWhere('k.vermittler = :vermittlerId')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->setParameter('vermittlerId', $vermittlerId)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    /**
     * @param string $id
     * @param string $vermittlerId
     * @return array
     */
    public function findByKundeIdVermittleId(string $kundeId, string $vermittlerId): array
    {
        return $this->createQueryBuilder('u')
            ->leftjoin('u.kundenid', 'k')
            ->andWhere('k.id = :kundeid')
            ->andWhere('k.vermittler = :vermittlerId')
            ->andWhere('k.geloescht != :del')
            ->setParameter('vermittlerId', $vermittlerId)
            ->setParameter('kundeid', $kundeId)
            ->setParameter('del', 1)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
