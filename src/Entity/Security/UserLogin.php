<?php

namespace App\Entity\Security;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Constraint\PasswordConstraint;
use App\Entity\Kunde;
use App\Enum\SerializerGroups;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints;

#[ORM\Table(name: 'sec.user')]
#[ORM\Entity]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'user',),
        new Get(uriTemplate: 'user/{id}'),
    ],
    normalizationContext: ['groups' => [
        SerializerGroups::READ_COMMON,
        SerializerGroups::READ_USERLOGIN,
    ]],
)]
#[ApiResource(
    uriTemplate: '/kunden/{id}/user',
    operations: [
        new Get(),
    ],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'user',
            fromClass: Kunde::class
        ),
    ],
    normalizationContext: ['groups' => [
        SerializerGroups::READ_COMMON,
    ]],
)]
class UserLogin
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: 'email', length: 200, nullable: true)]
    #[Groups([SerializerGroups::READ_USERLOGIN])]
    #[Constraints\NotBlank]
    #[Constraints\Email]
    private ?string $username = null;

    #[ORM\Column(length: 60, nullable: true)]
    #[Constraints\NotBlank]
    #[PasswordConstraint]
    private ?string $passwd = null;

    #[ORM\Column(nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?bool $aktiv = null;

    #[Context(normalizationContext: [
        DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    #[Groups([SerializerGroups::READ_USERLOGIN])]
    private Kunde $kunde;


    public function getId() : int
    {
        return $this->id;
    }


    public function setId(int $id) : void
    {
        $this->id = $id;
    }


    public function getUsername() : ?string
    {
        return $this->username;
    }


    public function setUsername(?string $username) : void
    {
        $this->username = $username;
    }


    public function getPasswd() : ?string
    {
        return $this->passwd;
    }


    public function setPasswd(?string $passwd) : void
    {
        $this->passwd = $passwd;
    }


    public function getAktiv() : ?bool
    {
        return $this->aktiv;
    }


    public function setAktiv(?bool $aktiv) : void
    {
        $this->aktiv = $aktiv;
    }


    public function getLastLogin() : ?DateTimeInterface
    {
        return $this->lastLogin;
    }


    public function setLastLogin(?DateTimeInterface $lastLogin) : void
    {
        $this->lastLogin = $lastLogin;
    }


    public function getKunde() : Kunde
    {
        return $this->kunde;
    }


    public function setKunde(Kunde $kunde) : void
    {
        $this->kunde = $kunde;
    }
}
