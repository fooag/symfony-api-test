<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\AdresseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ORM\Table(name: 'std.adresse')]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/kunden/{id}/adressen',
    operations: [new GetCollection()],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'adressen',
            fromClass: Kunde::class
        )
    ]
)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'adresse_id')]
    #[Groups('kunde')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('kunde')]
    private ?string $strasse = null;

    #[ORM\Column(length: 10, nullable: true)]
    #[Groups('kunde')]
    private ?string $plz = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups('kunde')]
    private ?string $ort = null;

    #[Groups('kunde')]
    private ?string $bundesland = null;

    #[ORM\ManyToOne(targetEntity: Bundesland::class)]
    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    private ?Bundesland $bundeslandRelation = null;

    #[Groups('kunde')]
    #[ORM\OneToOne(targetEntity: KundeAdresse::class, mappedBy: 'adressenId')]
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

    public function getBundeslandRelation(): ?Bundesland
    {
        return $this->bundeslandRelation;
    }

    public function setBundeslandRelation(?Bundesland $bundesland): self
    {
        $this->bundeslandRelation = $bundesland;

        return $this;
    }

    public function getBundesland(): ?string
    {
        return $this->bundeslandRelation->getKuerzel();
    }

    /**
     * @return KundeAdresse|null
     */
    public function getDetails(): ?KundeAdresse
    {
        return $this->details;
    }

    /**
     * @param KundeAdresse|null $details
     */
    public function setDetails(?KundeAdresse $details): void
    {
        $this->details = $details;
    }
}
