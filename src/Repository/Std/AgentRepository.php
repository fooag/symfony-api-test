<?php

declare(strict_types=1);

namespace App\Repository\Std;

use App\Entity\Std\Agent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * repository class for agent entity
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Repository\Std
 * @version   1.0.0
 * @since     1.0.0
 *
 * @method \App\Entity\Std\Agent find($id, $lockMode = null, $lockVersion = null)
 * @method \App\Entity\Std\Agent findAll()
 * @method \App\Entity\Std\Agent findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method \App\Entity\Std\Agent findOneBy(array $criteria, array $orderBy = null)
 */
class AgentRepository extends ServiceEntityRepository
{
    /**
     * class constructor
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agent::class);
    }
}
