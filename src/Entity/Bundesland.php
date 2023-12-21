<?php

namespace App\Entity;

use App\Repository\BundeslandRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
#[ORM\Table(name: "public.bundesland")]

class Bundesland
{
    #[Groups(['adresse.read', 'adresse.write', 'kunde.read', 'sub.adresse.read'])]
    #[ORM\Id]
    #[ORM\Column(length: 2)]
    private ?string $kuerzel = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    public function getId(): ?string
    {
        return $this->kuerzel;
    }

    public function getKuerzel(): ?string
    {
        return $this->kuerzel;
    }

    public function setKuerzel(string $kuerzel): self
    {
        $this->kuerzel = $kuerzel;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
