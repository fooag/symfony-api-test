<?php

declare(strict_types=1);

namespace App\Repository\Factory;

use App\Entity\KundeAdresse;

class KundeAdressFactory
{
    public static function buildKundeAdress(array $adresse): KundeAdresse
    {
        return new KundeAdresse(
            (string)$adresse['adresse_id'] ?? '',
                (bool)$adresse['geschaeftlich'] ?? false,
                (bool)$adresse['rechnungsadresse'] ?? false
        );
    }
}