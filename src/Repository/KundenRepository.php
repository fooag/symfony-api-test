<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Kunde;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kunde>
 *
 * @method Kunde|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kunde|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kunde[]    findAll()
 * @method Kunde[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KundenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kunde::class);
    }

    public function findByVermittlerId(int $vermittlerId): Collection
    {
        return new ArrayCollection($this->findBy(['vermittler' => $vermittlerId]));
    }
}
