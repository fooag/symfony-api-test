<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BundeslandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
#[ORM\Table(name: 'public.bundesland')]
#[ApiResource]
class Bundesland
{
    #[ORM\Id]
    #[ORM\Column(name: 'kuerzel', type: Types::STRING, length: 2, options: ['fixed' => true])]
    private ?string $kuerzel = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'bundeslandRelation', targetEntity: Adresse::class)]
    private Collection $adresses;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
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

    /**
     * @return Collection<int, Adresse>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setBundeslandRelation($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getBundesland() === $this) {
                $adress->setBundeslandRelation(null);
            }
        }

        return $this;
    }
}
