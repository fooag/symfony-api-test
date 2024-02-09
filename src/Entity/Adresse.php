<?php

declare(strict_types=1);

namespace App\Entity;

use App\Common\Bundesland;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: "std.adresse")]
class Adresse
{
    #[Groups(['customer:read'])]
    #[ORM\Id, ORM\Column(name: 'adresse_id', type: 'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Groups(['customer:read'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $strasse = null;

    #[Groups(['customer:read'])]
    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $plz = null;

    #[Groups(['customer:read'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $ort = null;

    #[Groups(['customer:read'])]
    #[ORM\Column(type: "bundesland_enum", nullable: true)]
    private ?Bundesland $bundesland = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): void
    {
        $this->strasse = $strasse;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): void
    {
        $this->plz = $plz;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): void
    {
        $this->ort = $ort;
    }

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(?Bundesland $bundesland): void
    {
        $this->bundesland = $bundesland;
    }
}