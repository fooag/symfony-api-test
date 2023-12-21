<?php

namespace App\Repository;

use App\Entity\KundeAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KundeAdresse>
 *
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

    public function save(KundeAdresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(KundeAdresse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @param string $id
     * @param string $vermittlerId
     * @return array
     */
    public function findByIdVermittleId(string $id, string $vermittlerId): array
    {
        return $this->createQueryBuilder('kundeadresse')
            ->leftJoin('kundeadresse.kunde', 'k')
            ->andWhere('kundeadresse.adresse = :id')
            ->andWhere('k.vermittler = :val')
            ->andWhere('kundeadresse.geloescht = :del')
            ->setParameter('id', $id)
            ->setParameter('val', $vermittlerId)
            ->setParameter('del', false)
            ->orderBy('k.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return KundeAdresse[] Returns an array of KundeAdresse objects
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

//    public function findOneBySomeField($value): ?KundeAdresse
//    {
//        return $this->createQueryBuilder('k')
//            ->andWhere('k.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
