<?php

namespace App\Repository;

use App\Entity\KundeAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KundeAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method KundeAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method KundeAdresse[]    findAll()
 * @method KundeAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KundeAdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KundeAdresse::class);
    }

    // /**
    //  * @return KundeAdresse[] Returns an array of KundeAdresse objects
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
    public function findOneBySomeField($value): ?KundeAdresse
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
