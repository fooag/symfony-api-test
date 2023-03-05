<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/adressen.{_format}"},
 *         "post"={"path"="/adressen.{_format}"},
 *     },
 *     itemOperations={
 *         "get" = {"path"="/adressen/{id}.{_format}"},
 *         "put" = {"path"="/adressen/{id}.{_format}"},
 *         "delete" = {"path"="/adressen/{id}.{_format}"},
 *     },
 * )
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 * @ORM\Table(name="std.adresse")
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",          name="adresse_id", options={"autoincrement":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $strasse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private ?string $plz;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $ort;

    /**
     * @ORM\OneToOne(targetEntity=Bundesland::class, cascade={"persist"})
     * @ORM\JoinColumn(name="bundesland",            referencedColumnName="kuerzel", nullable=false)
     */
    private Bundesland $bundesland;

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

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(Bundesland $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }
}
