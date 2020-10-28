<?php

namespace App\Repository;

use App\Entity\Kunde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kunde|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kunde|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kunde[]    findAll()
 * @method Kunde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KundeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kunde::class);
    }

    // /**
    //  * @return Kunde[] Returns an array of Kunde objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Kunde
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
