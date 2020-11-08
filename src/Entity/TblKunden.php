<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TblKundenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\TblKundenController;

/**
 * @ApiResource(
 *     shortName="clients",
 *     normalizationContext={"groups"={"kunden"}},
 *     itemOperations={
 *         "get_kunde_adresse"={
 *             "method"="GET",
 *             "path"="/clients/{id}/adressen",
 *             "controller"=TblKundenController::class
 *         }
 *     }
 * )
 * @ApiFilter(
 *     NumericFilter::class, properties={"geloescht"}
 * )
 * @ORM\Entity(repositoryClass=TblKundenRepository::class)
 * @ORM\Table(schema="std")
 */
class TblKunden
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string", length=36)
     * @Groups({"kunden"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kunden"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kunden"})
     */
    private $vorname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $firma;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"kunden"})
     */
    private $geburtsdatum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $geloescht;

    /**
     * @ORM\Column(type="text")
     * @Groups({"kunden"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"kunden"})
     */
    private $geschlecht;

    /**
     * @ORM\ManyToOne(targetEntity="Vermittler", inversedBy="tblKunden")
     * @ORM\JoinColumn(nullable=false, name="vermittler_id", referencedColumnName="id")
     * @Groups({"kunden"})
     */
    private $vermittlerId;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity="User", mappedBy="kundenId", orphanRemoval=true)
     * @Groups({"kunden"})
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(string $geschlecht): self
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getVermittlerId(): ?Vermittler
    {
        return $this->vermittlerId;
    }

    public function setVermittlerId(int $vermittlerId): self
    {
        $this->vermittlerId = $vermittlerId;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }
}
