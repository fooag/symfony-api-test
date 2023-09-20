<?php

declare(strict_types=1);

namespace App\Model;

class AddKundeModel
{
    public function __construct(
        private readonly string $vorname,
        private readonly string $nachname,
        private readonly string $geburtsdatum,
        private readonly string $strasse,
        private readonly string $plz,
        private readonly string $bundesland,
        private readonly string $username,
        private readonly string $password
    ) {
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getGeburtsdatum(): string
    {
        return $this->geburtsdatum;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
