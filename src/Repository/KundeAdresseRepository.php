<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\Factory\KundeAdressFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class KundeAdresseRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function findByKundeId(string $kundeId): Collection
    {
        $query = "SELECT *
                  FROM std.kunde_adresse 
                      JOIN std.adresse 
                          ON std.kunde_adresse.adresse_id = std.adresse.adresse_id 
                  WHERE std.kunde_adresse.kunde_id = :kundeId AND std.kunde_adresse.geloescht = false";
        $stmt = $this->entityManager->getConnection()->prepare($query);

        $result = $stmt->executeQuery(['kundeId' => $kundeId]);
        $adressen = $result->fetchAllAssociative();
        $adressCollection = new ArrayCollection();
        foreach ($adressen as $adress) {
            $adressCollection->add(KundeAdressFactory::buildKundeAdresse($adress));
        }

        return $adressCollection;
    }
}
