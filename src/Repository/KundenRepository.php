<?php

declare(strict_types=1);

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

    public function findByVermittlerId(int $vermittlerId): array
    {
        return $this->findBy(['vermittler' => $vermittlerId]);
    }
}
