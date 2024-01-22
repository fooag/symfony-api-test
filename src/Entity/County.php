<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'bundesland')]
#[ORM\Entity]
class County
{
    #[ORM\Column(name: 'kuerzel', type: 'string', length: 2, nullable: false, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'bundesland_kuerzel_seq', allocationSize: 1, initialValue: 1)]
    private string $kuerzel;

    #[ORM\Column(name: 'name', type: 'text', nullable: false)]
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
