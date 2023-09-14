<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VermittlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ORM\Table(name: "std.vermittler")]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private string $nummer;

    #[ORM\Column]
    private string $vorname;

    #[ORM\Column]
    private string $nachname;

    #[ORM\Column]
    private string $firma;

    #[ORM\Column]
    private bool $geloescht;

    #[ORM\OneToMany(mappedBy: "vermittler", targetEntity: Kunden::class)]
    private Collection $kunden;

    #[ORM\OneToOne(mappedBy: "vermittler", targetEntity: VermittlerUser::class)]
    #[ORM\JoinColumn(referencedColumnName: "vermittler_id")]
    private VermittlerUser $vermittlerUser;

    public function __construct(
        string $nummer,
        string $vorname,
        string $nachname,
        string $firma,
        bool $geloescht,
        VermittlerUser $vermittlerUser,
        ?Collection $kunden = null,
    ) {
        $this->nummer = $nummer;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->firma = $firma;
        $this->geloescht = $geloescht;
        $this->vermittlerUser = $vermittlerUser;
        $this->kunden = $kunden ?? new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): string
    {
        return $this->nummer;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getFirma(): string
    {
        return $this->firma;
    }

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function getKunden(): Collection
    {
        return $this->kunden;
    }

    public function getVermittlerUser(): VermittlerUser
    {
        return $this->vermittlerUser;
    }
}
