<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'std.kunde_adresse')]
#[ORM\Entity(repositoryClass: KundeAdresseRepository::class)]
class KundeAdresse
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'details')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    private Adresse $adresseId;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Kunde::class, inversedBy: 'adressen')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id')]
    private Kunde $kundenId;

    #[ORM\Column(nullable: true)]
    #[Groups(['kunde', 'reading'])]
    private ?bool $geschaeftlich = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['kunde', 'reading'])]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column(nullable: false)]
    private bool $geloescht;

    public function getKundenId(): Kunde
    {
        return $this->kundenId;
    }

    public function setKundenId(Kunde $kundenId): void
    {
        $this->kundenId = $kundenId;
    }

    public function getAdresseId(): Adresse
    {
        return $this->adresseId;
    }

    public function setAdresseId(Adresse $adressenId): void
    {
        $this->adresseId = $adressenId;
    }

    public function isGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(?bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}