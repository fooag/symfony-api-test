<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: "std.kunde_adresse")]
class KundenAdresse
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Kunde::class, fetch: 'EAGER', inversedBy: 'kundenAdressen')]
    #[ORM\JoinColumn(name: "kunde_id", referencedColumnName: "id")]
    #[ApiProperty("https://schema.org/Kunde")]
    private Kunde $kunde;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: Adresse::class, fetch: 'EAGER')]
    #[ORM\JoinColumn(name: "adresse_id", referencedColumnName: "adresse_id")]
    #[Groups(['customer:read'])]
    private Adresse $adresse;

    #[Groups(['customer:read'])]
    private ?bool $geschaeftlich = false;

    #[Groups(['customer:read'])]
    private ?bool $rechnungsadresse = false;

    #[Groups(['customer:read'])]
    private ?bool $geloescht = false;

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getAdresse(): Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(?bool $geschaeftlich): void
    {
        $this->geschaeftlich = $geschaeftlich;
    }


    public function getRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): void
    {
        $this->rechnungsadresse = $rechnungsadresse;
    }

    public function getGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(?bool $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}