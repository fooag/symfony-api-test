<?php

declare(strict_types=1);

namespace App\Repository\Factory;

use App\Entity\ValueObject\AdressDetails;
use App\Entity\ValueObject\KundeAdresse;

class KundeAdressFactory
{
    public static function buildKundeAdresse(array $adresse): KundeAdresse
    {
        return new KundeAdresse(
            (int)$adresse['adresse_id'],
            (string)$adresse['strasse'],
            (string)$adresse['plz'],
            (string)$adresse['bundesland'],
            new AdressDetails(
                (bool)$adresse['geschaeftlich'],
                (bool)$adresse['rechnungsadresse']
            )
        );
    }
}
