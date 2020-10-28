<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=KundeAdresseRepository::class)
 */
class KundeAdresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $geschaeftlich = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rechnungsadresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $geloescht = false;

    /**
     * @ORM\ManyToOne(targetEntity=Kunde::class, inversedBy="kundeAdresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kunde;

    /**
     * @ORM\OneToOne(targetEntity=Adresse::class, inversedBy="kundeAdresse", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function setRechnungsadresse(?bool $rechnungsadresse): self
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

    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(?Kunde $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

}
