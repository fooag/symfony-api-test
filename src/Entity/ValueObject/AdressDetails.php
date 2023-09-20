<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

class AdressDetails
{
    public function __construct(
        private readonly bool $geschaeftlich,
        private readonly bool $rechnungsadresse
    ) {
    }

    public function getGeschaeftlich(): bool
    {
        return $this->geschaeftlich;
    }

    public function getRechnungsadresse(): bool
    {
        return $this->rechnungsadresse;
    }
}
