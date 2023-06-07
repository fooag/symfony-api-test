<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * State just stores the Bundesland as enumerative store.
 */
#[ORM\Entity(repositoryClass: StateRepository::class),
    ORM\Table(name: 'public.bundesland')]
class State
{
    #[ORM\Id,
        ORM\GeneratedValue(strategy: 'AUTO'),
        ORM\Column(name: 'kuerzel', type: Types::STRING, length: 2, nullable: true)]
    #[SerializedName('bundesland')]
    #[Groups(['address:read', 'kunde:read'])]
    private ?string $shortName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    public function getShortName(): ?string
    {
        return $this->shortName;
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
