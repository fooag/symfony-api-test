<?php

declare(strict_types=1);

namespace App\Entity;

class KundeAdresse
{
    public function __construct(
        private readonly string $adresseId,
        private readonly bool $geschaeftlich,
        private readonly bool $rechnungsAdresse,
    ) {
    }

    public function getAdresseId(): string
    {
        return $this->adresseId;
    }

    public function isGeschaeftlich(): bool
    {
        return $this->geschaeftlich;
    }

    public function isRechnungsAdresse(): bool
    {
        return $this->rechnungsAdresse;
    }
}
