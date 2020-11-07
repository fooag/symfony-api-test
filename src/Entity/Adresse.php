<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *  shortName="adressen"
 * )
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 * @ORM\Table(schema="std")
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $adresseId;

    /**
     * @ORM\Column(type="text")
     */
    private $strasse;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $plz;

    /**
     * @ORM\Column(type="text")
     */
    private $ort;

    /**
     * @ORM\ManyToOne(targetEntity="Bundesland", inversedBy="adressen")
     * @ORM\JoinColumn(nullable=false, name="bundesland", referencedColumnName="kuerzel")
     */
    private $bundesland;

    public function getAdresseId(): ?int
    {
        return $this->adresseId;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(?Bundesland $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }
}
