<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VermittlerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VermittlerRepository::class)
 * @ORM\Table(name="std.vermittler")
 */
class Vermittler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",          options={"autoincrement":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=36, nullable=true)
     */
    private ?string $nummer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $vorname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $nachname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $firma;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $geloescht;

    /**
     * @ORM\OneToMany(targetEntity=TblKunden::class, mappedBy="vermittler_id")
     */
    private Collection $tblKundens;

    public function __construct()
    {
        $this->tblKundens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(?string $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

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

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(?bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    /**
     * @return Collection<int, TblKunden>
     */
    public function getTblKundens(): Collection
    {
        return $this->tblKundens;
    }

    public function addTblKunden(TblKunden $tblKunden): self
    {
        if (!$this->tblKundens->contains($tblKunden)) {
            $this->tblKundens[] = $tblKunden;
            $tblKunden->setVermittlerId($this);
        }

        return $this;
    }

    public function removeTblKunden(TblKunden $tblKunden): self
    {
        if ($this->tblKundens->removeElement($tblKunden)) {
            // set the owning side to null (unless already changed)
            if ($tblKunden->getVermittlerId() === $this) {
                $tblKunden->setVermittlerId(null);
            }
        }

        return $this;
    }
}
