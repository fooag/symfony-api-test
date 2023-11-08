<?php

namespace App\Entity\Security;

use App\Entity\Kunde;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Table(name: 'sec.user')]
#[ORM\Entity]
class UserLogin
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: 'email', length: 200, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aktiv = null;

    #[Context(normalizationContext: [
        DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
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
