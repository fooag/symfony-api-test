<?php

namespace App\Entity;

use App\Repository\VermittlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VermittlerRepository::class)
 * @ORM\Table(schema="std")
 */
class Vermittler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"kunden"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $nummer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vorname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nachname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firma;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $geloescht;

    /**
     * @ORM\OneToMany(targetEntity="TblKunden", mappedBy="vermittlerId", orphanRemoval=true)
     */
    private $tblKunden;

    /**
     * @ORM\OneToMany(targetEntity="VermittlerUser", mappedBy="vermittlerId", orphanRemoval=true)
     */
    private $vermittlerUsers;

    public function __construct()
    {
        $this->tblKunden = new ArrayCollection();
        $this->vermittlerUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

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

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(string $firma): self
    {
        $this->firma = $firma;

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

    public function getTblKunden(): Collection
    {
        return $this->tblKunden;
    }

    public function getVermittlerUsers(): Collection
    {
        return $this->vermittlerUsers->get('id');
    }
}
