<?php

namespace App\Repository;

use App\Entity\Adresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Adresse>
 *
 * @method Adresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adresse[]    findAll()
 * @method Adresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adresse::class);
    }

    public function save(Adresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Adresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param $value
     * @return array
     */
    public function findByVermittleId($value): array
    {
        return $this->createQueryBuilder('adresse')
            ->Join('adresse.kundeAdresses', 'ka')
            ->leftJoin('ka.kunde', 'k')
            ->andWhere('k.vermittler = :val')
            ->andWhere('ka.geloescht = :del')
            ->setParameter('val', $value)
            ->setParameter('del', false)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $id
     * @param string $vermittlerId
     * @return array
     */
    public function findByIdVermittleId(string $id, string $vermittlerId): Adresse
    {
        return $this->createQueryBuilder('adresse')
            ->leftJoin('adresse.kundeAdresses', 'ka')
            ->leftJoin('ka.kunde', 'k')
            ->andWhere('adresse.id = :id')
            ->andWhere('k.vermittler = :val')
            ->andWhere('ka.geloescht = :del')
            ->setParameter('id', $id)
            ->setParameter('val', $vermittlerId)
            ->setParameter('del', false)
            ->orderBy('k.id', 'ASC')
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
        return $this->createQueryBuilder('adresse')
            ->leftJoin('adresse.kundeAdresses', 'ka')
            ->leftJoin('ka.kunde', 'k')
            ->andWhere('k.id = :kundeId')
            ->andWhere('k.vermittler = :val')
            ->andWhere('ka.geloescht = :del')
            ->setParameter('kundeId', $kundeId)
            ->setParameter('val', $vermittlerId)
            ->setParameter('del', false)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param string $id
     * @param string $vermittlerId
     * @return array
     */
    public function findDetailsByKundeIdVermittleId(string $kundeId, string $adresseId, string $vermittlerId): array
    {
        return $this->createQueryBuilder('adresse')
            ->leftJoin('adresse.kundeAdresses', 'ka')
            ->leftJoin('ka.kunde', 'k')
            ->andWhere('k.id = :kundeId')
            ->andWhere('adresse.id = :adresseId')
            ->andWhere('k.vermittler = :vermittler')
            ->andWhere('ka.geloescht = :del')
            ->setParameter('adresseId', $adresseId)
            ->setParameter('kundeId', $kundeId)
            ->setParameter('vermittler', $vermittlerId)
            ->setParameter('del', false)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
//    /**
//     * @return Adresse[] Returns an array of Adresse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Adresse
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
