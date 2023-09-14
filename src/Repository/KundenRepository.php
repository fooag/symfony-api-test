<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Kunden;
use App\Repository\Factory\KundeAdressFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\ResultSetMapping;
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

    public function findByVermittlerId(int $vermittlerId): Collection
    {
        return new ArrayCollection($this->findBy(['vermittler' => $vermittlerId]));
    }
}
