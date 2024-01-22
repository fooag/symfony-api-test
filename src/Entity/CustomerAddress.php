<?php

declare(strict_types=1);

namespace App\Entity;

class CustomerAddress
{
    private string $kundeId;
    private int $adresseId;
    private bool $geschaeftlich;
    private bool $rechnugsadresse;

    public function getKundeId(): string
    {
        return $this->kundeId;
    }

    public function setKundeId(string $kundeId): self
    {
        $this->kundeId = $kundeId;

        return $this;
    }

    public function getAdresseId(): int
    {
        return $this->adresseId;
    }

    public function setAdresseId(int $adresseId): self
    {
        $this->adresseId = $adresseId;

        return $this;
    }

    public function isGeschaeftlich(): bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnugsadresse(): bool
    {
        return $this->rechnugsadresse;
    }

    public function setRechnugsadresse(bool $rechnugsadresse): self
    {
        $this->rechnugsadresse = $rechnugsadresse;

        return $this;
    }
}
