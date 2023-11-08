<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'std.adresse')]
#[ORM\Entity]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'adresse_id')]
    private ?int $adresseId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $strasse = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $plz = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ort = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $bundesland = null;

    #[ORM\OneToOne(mappedBy: 'adresse', targetEntity: AdresseDetails::class)]
    private AdresseDetails $details;


    public function getAdresseId() : int
    {
        return $this->adresseId;
    }


    public function setAdresseId(int $adresseId) : void
    {
        $this->adresseId = $adresseId;
    }


    public function getStrasse() : ?string
    {
        return $this->strasse;
    }


    public function setStrasse(?string $strasse) : void
    {
        $this->strasse = $strasse;
    }


    public function getPlz() : ?string
    {
        return $this->plz;
    }


    public function setPlz(?string $plz) : void
    {
        $this->plz = $plz;
    }


    public function getOrt() : ?string
    {
        return $this->ort;
    }


    public function setOrt(?string $ort) : void
    {
        $this->ort = $ort;
    }


    public function getBundesland() : ?string
    {
        return $this->bundesland;
    }


    public function setBundesland(?string $bundesland) : void
    {
        $this->bundesland = $bundesland;
    }


    public function getDetails() : AdresseDetails
    {
        return $this->details;
    }


    public function setDetails(AdresseDetails $details) : void
    {
        $this->details = $details;
    }
}
