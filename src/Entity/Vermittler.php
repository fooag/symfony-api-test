<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VermittlerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private ?string $nummer = null; // @todo field not nullable cause a generated default (see table)

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column]
    private ?bool $geloescht = null;

    #[ORM\OneToOne(mappedBy: 'vermittler')]
    private VermittlerUser $vermittlerUser;

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

    public function setFirma(string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getVermittlerUser(): VermittlerUser
    {
        return $this->vermittlerUser;
    }

    public function setVermittlerUser(VermittlerUser $vermittlerUser): self
    {
        // set the owning side of the relation if necessary
        if ($vermittlerUser->getVermittler() !== $this) {
            $vermittlerUser->setVermittler($this);
        }

        $this->vermittlerUser = $vermittlerUser;

        return $this;
    }
}
