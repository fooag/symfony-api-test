<?php

namespace App\Entity;

use App\Repository\BundeslandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BundeslandRepository::class)
 * @ORM\Table(name="public.bundesland")
 */
class Bundesland
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column( name="kuerzel", type="string")
     */
    private string $kuerzel;

    /**
     * @ORM\Column(type="text")
     */
    private string $name;

    public function getKuerzel(): ?string
    {
        return $this->kuerzel;
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
}
