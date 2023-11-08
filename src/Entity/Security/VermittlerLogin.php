<?php

namespace App\Entity\Security;

use App\Entity\Vermittler;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Table(name: 'sec.vermittler_user')]
#[ORM\Entity]
class VermittlerLogin
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aktiv = null;

    #[Context(normalizationContext: [
        DateTimeNormalizer::FORMAT_KEY => 'Y-m-d',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'login', targetEntity: Vermittler::class)]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    private Vermittler $vermittler;


    public function getId() : int
    {
        return $this->id;
    }


    public function setId(int $id) : void
    {
        $this->id = $id;
    }


    public function getEmail() : ?string
    {
        return $this->email;
    }


    public function setEmail(?string $email) : void
    {
        $this->email = $email;
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


    public function getVermittler() : Vermittler
    {
        return $this->vermittler;
    }


    public function setVermittler(Vermittler $vermittler) : void
    {
        $this->vermittler = $vermittler;
    }
}
