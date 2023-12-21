<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\Delete\DeleteController;
use App\Controller\Get\GetController;
use App\Repository\VermittlerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "std.vermittler")]
#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ApiResource(operations: [
    new Get(
        controller: GetController::class
    )
])]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36, nullable: false, options:["default"=> 'upper("left"((gen_random_uuid())::text, 8))'])]
    private string $nummer;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(nullable: false, options:["default"=> false])]
    private ?bool $geloescht = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}
