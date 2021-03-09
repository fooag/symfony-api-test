<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Std.adresse
 *
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
 *     normalizationContext={"groups"={"adresse", "adresse:read"}},
 *     denormalizationContext={"groups"={"adresse", "adresse:write"}},
 * )
 * @ORM\Table(name="std.adresse", indexes={@ORM\Index(name="IDX_40A5D758593BEEEC", columns={"bundesland"})})
 * @ORM\Entity
 */
class Adresse
{
    /**
     * @var int
     *
     * @ORM\Column(name="adresse_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $adresseId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strasse", type="text", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"adresse", "kunde:read"})
     */
    private $strasse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plz", type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"adresse", "kunde:read"})
     */
    private $plz;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ort", type="text", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"adresse", "kunde:read"})
     */
    private $ort;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     * @Assert\NotBlank()
     * @Groups({"adresse", "kunde:read"})
     */
    private $bundesland;

    /**
     * @var Collection<Kunde>
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Kunde")
     * @ORM\JoinTable(name="std.kunde_adresse",
     *      joinColumns={@ORM\JoinColumn(name="adresse_id", referencedColumnName="adresse_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="kunde_id", referencedColumnName="id")}
     * )
     *
     * @Groups({"adresse:read"})
     */
    private $kunden;

    /**
     * @var Collection<KundenAdressenRelation>
     *
     * @ORM\OneToMany(targetEntity="KundenAdressenRelation", mappedBy="adresse")
     */
    private $kundenRelations;

    public function __construct()
    {
        $this->kundenRelations = new ArrayCollection([]);
        $this->kunden = new ArrayCollection([]);
    }

    public function getAdresseId(): int
    {
        return $this->adresseId;
    }

    public function setAdresseId(int $adresseId): void
    {
        $this->adresseId = $adresseId;
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

    public function getBundesland(): string
    {
        return $this->bundesland;
    }

    public function setBundesland(string $bundesland): void
    {
        $this->bundesland = $bundesland;
    }

    public function getKundenRelations(): Collection
    {
        return $this->kundenRelations;
    }

    public function setKundenRelations(Collection $kundenRelations): void
    {
        $this->kundenRelations = $kundenRelations;
    }

    public function getKunden(): Collection
    {
        return $this->kunden;
    }

    public function setKunden(Collection $kunden): void
    {
        $this->kunden = $kunden;
    }
}
