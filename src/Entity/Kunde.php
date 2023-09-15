<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\KundenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KundenRepository::class)]
#[ORM\Table(name: 'std.tbl_kunden')]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: 'kunden/{id}',
        ),
        new GetCollection(
            uriTemplate: 'kunden'
        )
    ]
)]
class Kunden
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $vorname;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private string $firma;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $geburtsdatum;

    #[ORM\Column]
    private bool $geloescht;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $geschlecht;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\ManyToOne(targetEntity: Vermittler::class, inversedBy: 'kunden')]
    #[ORM\JoinColumn(nullable: false)]
    private Vermittler $vermittler;

    private Collection $adressen;

    public function __construct(
        string $name,
        string $vorname,
        string $firma,
        string $geburtsdatum,
        bool $geloescht,
        string $geschlecht,
        string $email,
        Vermittler $vermittler,
    ) {
        $this->name = $name;
        $this->vorname = $vorname;
        $this->firma = $firma;
        $this->geburtsdatum = $geburtsdatum;
        $this->geloescht = $geloescht;
        $this->geschlecht = $geschlecht;
        $this->email = $email;
        $this->vermittler = $vermittler;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getFirma(): string
    {
        return $this->firma;
    }

    public function getGeburtsdatum(): string
    {
        return $this->geburtsdatum;
    }

    #[Ignore]
    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function getGeschlecht(): string
    {
        return $this->geschlecht;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    #[Ignore]
    public function getVermittler(): Vermittler
    {
        return $this->vermittler;
    }

    public function getVermittlerId(): int
    {
        return $this->vermittler->getId();
    }

    public function setAddressen(Collection $addressen): self
    {
        $this->adressen = $addressen;

        return $this;
    }

    public function getAdressen(): Collection
    {
        return $this->adressen;
    }
}
