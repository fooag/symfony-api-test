<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table(name="std.kunde_adresse")
 * @ORM\Entity()
 */
class KundenAdressenRelation implements SoftDeletable
{
    /**
     * @var Kunde
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Kunde", inversedBy="kundeAdressen")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"adresse:read"})
     */
    private $kunde;

    /**
     * @var Adresse
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse")
     * @ORM\JoinColumn(name="adresse_id", referencedColumnName="adresse_id", nullable=false)
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"adresse:read"})
     */
    private $geschaeftlich;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"adresse:read"})
     */
    private $rechnungsadresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $geloescht;

    public function getGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function getRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function getGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

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
}
