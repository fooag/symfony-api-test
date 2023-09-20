<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Doctrine\Generators\KundenIdGenerator;
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
            uriTemplate: 'foo/kunden/{id}',
        ),
        new GetCollection(
            uriTemplate: 'foo/kunden'
        ),
        new Post(
            uriTemplate: 'foo/kunden'
        ),
    ]
)]
class Kunde
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: KundenIdGenerator::class)]
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

    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: User::class, cascade: ['persist'])]
    private User $user;

    private Collection $adressen;

    public function __construct(
        string $name,
        string $vorname,
        string $firma,
        string $geburtsdatum,
        string $geschlecht,
        string $email,
        Vermittler $vermittler,
        User $user
    ) {
        $this->name = $name;
        $this->vorname = $vorname;
        $this->firma = $firma;
        $this->geburtsdatum = $geburtsdatum;
        $this->geloescht = false;
        $this->geschlecht = $geschlecht;
        $this->email = $email;
        $this->vermittler = $vermittler;
        $this->user = $user;
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

    public function getUser(): User
    {
        return $this->user;
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
