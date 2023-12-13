<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'public.bundesland')]
class Bundesland
{
    #[ORM\Id, ORM\Column(type: 'string', length: 2)]
    private string $kuerzel;

    #[ORM\Column]
    private string $name;

    public function getKuerzel(): string
    {
        return $this->kuerzel;
    }

    public function setKuerzel(string $kuerzel): self
    {
        $this->kuerzel = $kuerzel;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
