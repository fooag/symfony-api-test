<?php

declare(strict_types=1);

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
final class KundeAdresseRepository extends ServiceEntityRepository
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
}
