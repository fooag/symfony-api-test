<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Factory\CustomerAddressFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class CustomerAddressRepository implements CustomerAddressRepositoryInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function findAllByCustomerId(string $id): Collection
    {
        $query = '
select *
from std.kunde_adresse
inner join std.adresse on std.kunde_adresse.adresse_id = std.adresse.adresse_id
where std.kunde_adresse.kunde_id = :kundeId
and std.kunde_adresse.geloescht = false
';

        $stmt = $this->entityManager->getConnection()->prepare($query);
        $result = $stmt->executeQuery(['kundeId' => $id]);

        $data = $result->fetchAllAssociative();
        $adresseCollection = new ArrayCollection();
        foreach ($data as $item) {
            $adresseCollection->add(CustomerAddressFactory::createCustomerAddress($item));
        }

        return $adresseCollection;
    }

    public function findAllByCustomerIds(array $ids): Collection
    {
        $query = '
select *
from std.kunde_adresse
inner join std.adresse on std.kunde_adresse.adresse_id = std.adresse.adresse_id
where std.kunde_adresse.kunde_id in (:kundeIds)
and std.kunde_adresse.geloescht = false
';

        $stmt = $this->entityManager->getConnection()->prepare($query);
        $result = $stmt->executeQuery(['kundeIds' => implode(',', $ids)]);

        $data = $result->fetchAllAssociative();
        $addressCollection = new ArrayCollection();
        foreach ($data as $item) {
            $addressCollection->add(CustomerAddressFactory::createCustomerAddress($item));
        }

        return $addressCollection;
    }
}
