<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'std.tbl_kunden')]
#[ApiResource(
    uriTemplate: '/kunden/{id}',
    operations: [
        new GetCollection(uriTemplate: '/kunden'),
        new Post(uriTemplate: '/kunden'),
        new Get(),
        new Put(),
        new Delete(),
    ],
    routePrefix: '/foo',
)]
class Kunde
{
    #[ORM\Id, ORM\Column(length: 36), ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?string $id = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column]
    private ?string $vorname = null;

    #[ORM\Column]
    private ?string $firma = null;

    #[ORM\Column]
    private ?DateTimeImmutable $geburtsdatum = null;

    #[ORM\Column]
    private int $geloescht = 0;

    #[ORM\Column]
    private ?int $geschlecht = null; // TODO TYPE public.geschlecht AS enum ('männlich', 'weiblich', 'divers')

    #[ORM\Column]
    private ?string $email = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
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

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;
        return $this;
    }

    public function getGeburtsdatum(): ?DateTimeImmutable
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?DateTimeImmutable $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;
        return $this;
    }

    public function isGeloescht(): bool
    {
        return (bool) $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = (int) $geloescht;
        return $this;
    }

    public function getGeschlecht(): ?int
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?int $geschlecht): self
    {
        $this->geschlecht = $geschlecht;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
