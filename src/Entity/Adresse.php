<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\AdresseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'std.adresse')]
#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/adressen/{id}'),
        new Put(uriTemplate: '/adressen/{id}'),
        new Delete(uriTemplate: '/adressen/{id}'),
        new Post(uriTemplate: '/adressen'), // @todo not working permission error with adresse_adresse_id_seq
        new GetCollection(uriTemplate: '/adressen'),
    ],
    normalizationContext: ['groups' => ['reading'], 'skip_null_values' => false],
    denormalizationContext: ['groups' => ['writing']]
)]
#[ApiResource(
    uriTemplate: '/kunden/{id}/adressen',
    operations: [
        new GetCollection(),
    ],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'adressen',
            fromClass: Kunde::class
        )
    ],
    normalizationContext: ['groups' => ['reading'], 'skip_null_values' => false],
)]
#[ApiResource(
    uriTemplate: '/kunden/{kundeId}/adressen/{id}/details',
    operations: [
        new Get(),
    ],
    uriVariables: [
        'kundeId' => new Link(
            fromProperty: 'adressen',
            fromClass: Kunde::class
        ),
        'id' => new Link(
            fromProperty: 'details',
            fromClass: Adresse::class
        )
    ],
    normalizationContext: ['groups' => ['reading'], 'skip_null_values' => false],
)]
class Adresse
{
    private const BUNDESLAENDER = [
        'BW', 'BY', 'BE', 'BB', 'HB', 'HH', 'HE', 'NI', 'MV', 'NW', 'RP', 'SL', 'SN', 'ST', 'SH', 'TH'
    ]; // @todo get from bundesland table

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'adresse_id')]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'integer',
            'description' => 'ID der Adresse',
            'example' => 2,
            'required' => true,
        ]
    )]
    #[Groups(['kunde', 'reading'])]
    private ?int $id = null; // @todo should be addresseId in kunde group ouput

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Groups(['kunde', 'reading', 'writing'])]
    private ?string $strasse = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Assert\NotBlank]
    #[Groups(['kunde', 'reading', 'writing'])]
    private ?string $plz = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank]
    #[Groups(['kunde', 'reading', 'writing'])]
    private ?string $ort = null;

    #[ORM\Column(length: 2, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: self::BUNDESLAENDER)]
    #[Groups(['kunde', 'reading', 'writing'])]
    private ?string $bundesland = null;

    #[ORM\OneToOne(mappedBy: 'adresseId', targetEntity: KundeAdresse::class)]
    #[Groups(['kunde', 'reading', 'writing'])]
    private ?KundeAdresse $details = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?string
    {
        return $this->bundesland;
    }

    public function setBundesland(?string $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }

    public function getDetails(): ?KundeAdresse
    {
        return $this->details;
    }

    public function setDetails(?KundeAdresse $details): void
    {
        $this->details = $details;
    }
}
