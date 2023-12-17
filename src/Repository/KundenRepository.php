<?php

namespace App\Repository;

use App\Entity\Kunden;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kunden>
 *
 * @method Kunden|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kunden|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kunden[]    findAll()
 * @method Kunden[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KundenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kunden::class);
    }

    public function save(Kunden $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Kunden $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Kunden[] Returns an array of Kunden objects
    */
    public function findByVermittleId($value): array
    {
        return $this->createQueryBuilder('k')
            ->join('k.vermittler', 'v')
            ->andWhere('v.id = :val')
            ->andWhere('k.geloescht = :del')
            ->setParameter('val', $value)
            ->setParameter('del', 0)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
    * @return Kunden[] Returns an array of Kunden objects
    */
    public function findByIdVermittleId(string $id, string $vermittlerId): Kunden
    {
        return $this->createQueryBuilder('k')
            ->join('k.vermittler', 'v')
            ->andWhere('k.id = :id')
            ->andWhere('v.id = :val')
            ->andWhere('k.geloescht = :del')
            ->setParameter('id', $id)
            ->setParameter('val', $vermittlerId)
            ->setParameter('del', 0)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getSingleResult()
            ;
    }



//    /**
//     * @return Kunden[] Returns an array of Kunden objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('k.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Kunden
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
