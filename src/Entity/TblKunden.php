<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TblKundenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     shortName="kunden",
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vorname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $firma;

    /**
     * @ORM\Column(type="datetime")
     */
    private $geburtsdatum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $geloescht;

    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $geschlecht;

    /**
     * @ORM\ManyToOne(targetEntity="Vermittler", inversedBy="tblKunden")
     * @ORM\JoinColumn(nullable=false, name="vermittler_id", referencedColumnName="id")
     */
    private $vermittlerId;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="kundenId", orphanRemoval=true)
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
