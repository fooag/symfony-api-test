<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/adressen"},
 *         "post"={"path"="/adressen"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/adressen/{id}",
 *          },
 *         "put"={
 *              "path"="/adressen/{id}",
 *          },
 *         "delete"={
 *              "path"="/adressen/{id}",
 *          },
 *     },
 * )
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 * @ORM\Table(schema="std", name="`adresse`")
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="adresse_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $strasse;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Assert\NotBlank
     */
    private $plz;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $ort;

    /**
     * @ORM\Column(type="string", length=2)
     * @Assert\NotBlank
     */
    private $bundesland;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kunde")
     * @ORM\JoinTable(name="kunde_adresse", schema="std",
     *      joinColumns={@ORM\JoinColumn(name="adresse_id", referencedColumnName="adresse_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="kunde_id", referencedColumnName="id")}
     *      )
     */
    private $kunde;

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

    public function setPlz(?string $plz): self
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

    /**
     * @return Kunde
     */
    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    /**
     * @param Kunde $kunde
     */
    public function setKunde(Kunde $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }
}
