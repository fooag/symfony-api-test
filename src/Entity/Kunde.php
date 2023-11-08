<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Security\UserLogin;
use App\Enum\SerializerGroups;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Table(name: 'std.tbl_kunden')]
#[ORM\Entity]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'kunden',),
        new Get(uriTemplate: 'kunden/{id}',),
    ],
    normalizationContext: ['groups' => [
        SerializerGroups::READ_KUNDE,
        SerializerGroups::READ_COMMON,
    ]],
)]
class Kunde
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(length: 36)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private string $id;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?string $vorname = null;

    #[Context(normalizationContext: [
        DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?bool $geloescht = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?string $geschlecht = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?string $email = null;

    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: UserLogin::class)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?UserLogin $user;

    #[ORM\Column(name: 'vermittler_id', nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private int $vermittlerId;

    #[ORM\JoinTable(name: 'std.kunde_adresse')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    #[ORM\ManyToMany(targetEntity: Adresse::class)]
    #[Groups([SerializerGroups::READ_KUNDE])]
    private Collection $adressen;


    public function getAdressen() : Collection
    {
        // Messy Workaround as I found no way to solve this issue in time
        /** @var Adresse $adresse */
        foreach($this->adressen as $adresse) {
            if ($adresse->getDetails()->isGeloescht()) {
                $this->adressen->removeElement($adresse);
            }
        }

        return new ArrayCollection(array_values($this->adressen->toArray()));
    }


    public function setAdressen(Collection $adressen) : void
    {
        $this->adressen = $adressen;
    }


    public function getVermittlerId() : int
    {
        return $this->vermittlerId;
    }


    public function setVermittlerId(int $vermittlerId) : void
    {
        $this->vermittlerId = $vermittlerId;
    }


    public function getId() : string
    {
        return $this->id;
    }


    public function setId(string $id) : void
    {
        $this->id = $id;
    }


    public function getName() : ?string
    {
        return $this->name;
    }


    public function setName(?string $name) : void
    {
        $this->name = $name;
    }


    public function getVorname() : ?string
    {
        return $this->vorname;
    }


    public function setVorname(?string $vorname) : void
    {
        $this->vorname = $vorname;
    }


    public function getGeburtsdatum() : ?DateTimeInterface
    {
        return $this->geburtsdatum;
    }


    public function setGeburtsdatum(?DateTimeInterface $geburtsdatum) : void
    {
        $this->geburtsdatum = $geburtsdatum;
    }


    public function getGeloescht() : ?bool
    {
        return $this->geloescht;
    }


    public function setGeloescht(?bool $geloescht) : void
    {
        $this->geloescht = $geloescht;
    }


    public function getGeschlecht() : ?string
    {
        return $this->geschlecht;
    }


    public function setGeschlecht(?string $geschlecht) : void
    {
        $this->geschlecht = $geschlecht;
    }


    public function getEmail() : ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email) : void
    {
        $this->email = $email;
    }


    public function getUser() : ?UserLogin
    {
        return $this->user;
    }


    public function setUser(?UserLogin $user) : void
    {
        $this->user = $user;
    }
}
