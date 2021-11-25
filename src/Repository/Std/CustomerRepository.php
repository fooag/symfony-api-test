<?php

namespace App\Repository\Std;

use App\Entity\Std\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * repository class for customer entity
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Repository\Std
 * @version   1.0.0
 * @since     1.0.0
 *
 * @method \App\Entity\Std\Customer find($id, $lockMode = null, $lockVersion = null)
 * @method \App\Entity\Std\Customer findOneBy(array $criteria, array $orderBy = null)
 * @method \App\Entity\Std\Customer[] findAll()
 * @method \App\Entity\Std\Customer[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    /**
     * class constructor
     *
     * @param \Doctrine\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * find all customers, which are not deleted
     *
     * @return Customer[]
     */
    public function findActiveCustomerCollection(): array
    {
        $queryBuilder = $this->createQueryBuilder('customer')
            ->where('customer.isDeleted = :isDeleted')
            ->setParameter(':isDeleted', false)
            ->orderBy('customer.id', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * load customer by identifier but he has be active
     *
     * @param int $id
     *
     * @return \App\Entity\Std\Customer|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findActiveCustomerById(int $id): ?Customer
    {
        $queryBuilder = $this->createQueryBuilder('customer')
            ->where('customer.id = :customerId')
            ->andWhere('customer.isDeleted = :isDeleted')
            ->setParameter(':customerId', $id)
            ->setParameter(':isDeleted', false)
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
