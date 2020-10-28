<?php

namespace App\Repository;

use App\Entity\VermitterUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VermitterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VermitterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VermitterUser[]    findAll()
 * @method VermitterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VermitterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VermitterUser::class);
    }

    // /**
    //  * @return VermitterUser[] Returns an array of VermitterUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VermitterUser
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
