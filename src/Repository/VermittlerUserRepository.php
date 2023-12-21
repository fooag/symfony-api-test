<?php

namespace App\Repository;

use App\Entity\VermittlerUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VermittlerUser>
 *
 * @method VermittlerUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VermittlerUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VermittlerUser[]    findAll()
 * @method VermittlerUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VermittlerUserRepository extends ServiceEntityRepository
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

//    /**
//     * @return VermittlerUser[] Returns an array of VermittlerUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VermittlerUser
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
