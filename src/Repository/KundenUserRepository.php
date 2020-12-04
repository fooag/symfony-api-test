<?php

namespace App\Repository;

use App\Entity\KundenUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KundenUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method KundenUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method KundenUser[]    findAll()
 * @method KundenUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KundenUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KundenUser::class);
    }

    // /**
    //  * @return KundenUser[] Returns an array of KundenUser objects
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
    public function findOneBySomeField($value): ?KundenUser
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
