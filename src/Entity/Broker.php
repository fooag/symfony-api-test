<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'std.vermittler')]
#[ORM\Entity]
class Broker
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'std.vermittler_id_seq', allocationSize: 1, initialValue: 1)]
    private int $id;

    #[ORM\Column(name: 'nummer', type: 'string', length: 36, nullable: false, options: ['default' => 'upper("left"((gen_random_uuid())::text, 8))'])]
    private string $nummer = 'upper("left"((gen_random_uuid())::text, 8))';

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(name: 'nachname', type: 'string', length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(name: 'firma', type: 'string', length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: false, options: ['default' => 'false'])]
    private bool $geloescht = false;

    #[ORM\OneToMany(mappedBy: 'vermittler', targetEntity: Customer::class)]
    private Collection $kunden;

    public function __construct() {
        $this->kunden = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNummer(): string
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

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getKunden(): Collection
    {
        return $this->kunden;
    }

    public function setKunden(Collection $kunden): self
    {
        $this->kunden = $kunden;

        return $this;
    }
}
