<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $strasse;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $plz;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ort;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bundesland;

    /**
     * @ORM\OneToOne(targetEntity=KundeAdresse::class, mappedBy="adresse", cascade={"persist", "remove"})
     */
    private $kundeAdresse;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?string
    {
        return $this->bundesland;
    }

    public function setBundesland(string $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }

    public function getKundeAdresse(): ?KundeAdresse
    {
        return $this->kundeAdresse;
    }

    public function setKundeAdresse(KundeAdresse $kundeAdresse): self
    {
        $this->kundeAdresse = $kundeAdresse;

        // set the owning side of the relation if necessary
        if ($kundeAdresse->getAdresse() !== $this) {
            $kundeAdresse->setAdresse($this);
        }

        return $this;
    }

}
