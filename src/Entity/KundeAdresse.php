<?php

namespace App\Entity;

use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KundeAdresseRepository::class)
 * @ORM\Table(name="std.kunde_adresse")
 */
class KundeAdresse
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=TblKunden::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="kunde_id",             nullable=false)
     */
    private TblKunden $kunde_id;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=Adresse::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="adresse_id",         referencedColumnName="adresse_id", nullable=false)
     */
    private Adresse $adresse_id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $geschaeftlich;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $rechnungsadresse;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $geloescht;

    public function getKundeId(): ?TblKunden
    {
        return $this->kunde_id;
    }

    public function setKundeId(TblKunden $kunde_id): self
    {
        $this->kunde_id = $kunde_id;

        return $this;
    }

    public function getAdresseId(): ?Adresse
    {
        return $this->adresse_id;
    }

    public function setAdresseId(Adresse $adresse_id): self
    {
        $this->adresse_id = $adresse_id;

        return $this;
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

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(?bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}
