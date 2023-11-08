<?php

namespace App\Entity;

use App\Entity\Security\VermittlerLogin;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'std.vermittler')]
#[ORM\Entity]
class Vermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 36)]
    private string $nummer;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column]
    private ?bool $geloescht = null;

    #[ORM\OneToOne(mappedBy: 'vermittler', targetEntity: VermittlerLogin::class)]
    private ?VermittlerLogin $login;


    public function getId() : ?int
    {
        return $this->id;
    }


    public function setId(?int $id) : void
    {
        $this->id = $id;
    }


    public function getNummer() : string
    {
        return $this->nummer;
    }


    public function setNummer(string $nummer) : void
    {
        $this->nummer = $nummer;
    }


    public function getVorname() : ?string
    {
        return $this->vorname;
    }


    public function setVorname(?string $vorname) : void
    {
        $this->vorname = $vorname;
    }


    public function getNachname() : ?string
    {
        return $this->nachname;
    }


    public function setNachname(?string $nachname) : void
    {
        $this->nachname = $nachname;
    }


    public function getFirma() : ?string
    {
        return $this->firma;
    }


    public function setFirma(?string $firma) : void
    {
        $this->firma = $firma;
    }


    public function getGeloescht() : ?bool
    {
        return $this->geloescht;
    }


    public function setGeloescht(?bool $geloescht) : void
    {
        $this->geloescht = $geloescht;
    }


    public function getLogin() : ?VermittlerLogin
    {
        return $this->login;
    }


    public function setLogin(?VermittlerLogin $login) : void
    {
        $this->login = $login;
    }
}
