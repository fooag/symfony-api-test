<?php

namespace App\Repository;

use App\Entity\Adresse;
use App\Entity\KundeAdresse;
use App\Entity\TblKunden;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TblKunden|null find($id, $lockMode = null, $lockVersion = null)
 * @method TblKunden|null findOneBy(array $criteria, array $orderBy = null)
 * @method TblKunden[]    findAll()
 * @method TblKunden[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TblKundenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TblKunden::class);
    }

    public function findKundeAdresse($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id = :val')
            ->setParameter('val', $value)
            ->leftJoin(KundeAdresse::class, 'kd', Join::WITH, 't.id = kd.kunde_id')
            //->leftJoin(Adresse::class, 'a', Join::WITH, 'a.adresse_id = kd.adresse_id')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return TblKunden[] Returns an array of TblKunden objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TblKunden
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
