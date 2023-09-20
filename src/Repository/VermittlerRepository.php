<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vermittler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vermittler>
 *
 * @method Vermittler|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vermittler|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vermittler[]    findAll()
 * @method Vermittler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VermittlerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vermittler::class);
    }
}
