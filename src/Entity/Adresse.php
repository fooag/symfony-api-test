<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'std.adresse')]
class Adresse
{
    #[ORM\Id, ORM\Column(name: 'adresse_id'), ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?string $id = null;

    #[ORM\Column]
    private ?string $strasse = null;

    #[ORM\Column(length: 10)]
    private ?string $plz = null;

    #[ORM\Column]
    private ?string $ort = null;

    #[ORM\ManyToOne(targetEntity: Bundesland::class), ORM\JoinColumn(name: 'bundesland')]
    private ?Bundesland $bundesland = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): self
    {
        $this->strasse = $strasse;
        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;
        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): self
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
