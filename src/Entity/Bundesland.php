<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BundeslandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BundeslandRepository::class)
 */
class Bundesland
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=2)
     */
    private $kuerzel;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Adresse", mappedBy="bundesland", orphanRemoval=true)
     */
    private $adressen;

    public function __construct()
    {
        $this->adressen = new ArrayCollection();
    }

    public function getKuerzel(): ?string
    {
        return $this->kuerzel;
    }

    public function setKuerzel(string $kuerzel): self
    {
        $this->kuerzel = $kuerzel;

        return $this;
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

    public function getAdressen(): Collection
    {
        return $this->adressen;
    }
}
