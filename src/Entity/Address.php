<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'std.adresse')]
#[ORM\Index(columns: ['bundesland'], name: 'IDX_40A5D758593BEEEC')]
#[ORM\Entity]
class Address
{
    #[ORM\Column(name: 'adresse_id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'std.adresse_adresse_id_seq', allocationSize: 1, initialValue: 1)]
    private int $adresseId;

    #[ORM\Column(name: 'strasse', type: 'text', nullable: true)]
    #[Assert\NotBlank(message: 'error.Address.strasse.notBlank')]
    private ?string $strasse = null;

    #[ORM\Column(name: 'plz', type: 'string', length: 10, nullable: true)]
    #[Assert\NotBlank(message: 'error.Address.plz.notBlank')]
    private ?string $plz = null;

    #[ORM\Column(name: 'ort', type: 'text', nullable: true)]
    #[Assert\NotBlank(message: 'error.Address.ort.notBlank')]
    private ?string $ort = null;

    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    #[ORM\ManyToOne(targetEntity: County::class)]
    #[Assert\NotBlank(message: 'error.Address.bundesland.notBlank')]
    private $bundesland;

    public function getAdresseId(): int
    {
        return $this->adresseId;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): void
    {
        $this->strasse = $strasse;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): void
    {
        $this->plz = $plz;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): void
    {
        $this->ort = $ort;
    }

    public function getBundesland()
    {
        return $this->bundesland;
    }

    public function setBundesland($bundesland): void
    {
        $this->bundesland = $bundesland;
    }
}
