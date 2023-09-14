<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

class KundeAdresse
{
    public function __construct(
        private readonly int $adresseId,
        private readonly string $strasse,
        private readonly string $plz,
        private readonly string $bundesland,
        private readonly AdressDetails $details
    ) {
    }

    public function getAdresseId(): int
    {
        return $this->adresseId;
    }

    public function getStrasse(): string
    {
        return $this->strasse;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function getBundesland(): string
    {
        return $this->bundesland;
    }

    public function getDetails(): AdressDetails
    {
        return $this->details;
    }
}
