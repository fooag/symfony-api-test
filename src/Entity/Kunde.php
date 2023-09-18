<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Doctrine\Generators\CustomIdGenerator;
use App\Repository\KundeRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: 'std.tbl_kunden')]
#[ORM\Entity(repositoryClass: KundeRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: 'kunden/{id}',
        ),
        new Post(
            uriTemplate: '/kunden',
        ),
        new Put(
            uriTemplate: '/kunden/{id}',
        ),
        new GetCollection(
            uriTemplate: '/kunden',
        ),
        new Delete(
            uriTemplate: '/kunden/{id}',
        ),
    ],
    normalizationContext: ['groups' => ['kunde']],
)]
class Kunde
{
    private const GESCHLECHTER = ['männlich', 'weiblich', 'divers'];

    // see https://symfony.com/doc/current/components/uid.html#storing-uuids-in-databases
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING, length: 8)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: CustomIdGenerator::class)]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'string',
            'format' => 'uuid',
            'description' => 'UUID des Kunden',
            'example' => '8C3C855C',
            'required' => true,
        ]
    )]
    #[Groups('kunde')]
    private ?string $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Groups('kunde')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Groups('kunde')]
    private ?string $vorname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Groups('kunde')]
    private ?string $firma = null;

    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('kunde')]
    private ?DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?int $geloescht = 0;

    #[ORM\Column(length: 255, nullable: true)] // @todo custom data type geschlecht ('männlich', 'weiblich', 'divers')
    #[Assert\Choice(choices: self::GESCHLECHTER)]
    #[Groups('kunde')]
    private ?string $geschlecht = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Email]
    #[Groups('kunde')]
    private ?string $email = null;

    #[ORM\Column(name: 'vermittler_id')] // @todo link to Vermittler Entity
    #[Groups('kunde')]
    private ?int $vermittlerId = null;

    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: User::class, cascade: ['persist'])]
    #[Groups('kunde')]
    private ?User $user;

    #[ORM\JoinTable(name: 'std.kunde_adresse')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    #[ORM\ManyToMany(targetEntity: Adresse::class)]
    #[Groups('kunde')]
    private Collection $adressen;

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

    public function getGeburtsdatum(): ?DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    #[Ignore]
    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): self
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

    public function getVermittlerId(): ?int
    {
        return $this->vermittlerId;
    }

    public function setVermittlerId(int $vermittlerId): self
    {
        $this->vermittlerId = $vermittlerId;

        return $this;
    }

    public function getUser(): ?User
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
