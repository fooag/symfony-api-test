<?php

namespace App\Repository;

use App\Entity\Vermittler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vermittler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vermittler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vermittler[]    findAll()
 * @method Vermittler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VermittlerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vermittler::class);
    }

    // /**
    //  * @return Vermittler[] Returns an array of Vermittler objects
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
    public function findOneBySomeField($value): ?Vermittler
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
