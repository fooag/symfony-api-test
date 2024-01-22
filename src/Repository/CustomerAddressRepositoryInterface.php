<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CustomerAddress;
use Doctrine\Common\Collections\Collection;

interface CustomerAddressRepositoryInterface
{
    /**
     * @return Collection<CustomerAddress>
     */
    public function findAllByCustomerId(string $id): Collection;

    /**
     * @return Collection<CustomerAddress>
     */
    public function findAllByCustomerIds(array $ids): Collection;
}