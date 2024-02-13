<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\VermittlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ORM\Table(name: "std.vermittler")]
#[ApiResource(
    operations: [
        new Get('/vermittler/{id}'),
    ]
)]
class Vermittler
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'vermittler', targetEntity: Kunde::class)]
    private Collection $kunden;

    public function __construct()
    {
        $this->kunden = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getKunden(): Collection
    {
        return $this->kunden;
    }

    public function setKunden(Collection $kunden): void
    {
        $this->kunden = $kunden;
    }
}