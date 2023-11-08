<?php

namespace App\Entity;

use App\Enum\SerializerGroups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: 'std.kunde_adresse')]
#[ORM\Entity]
class AdresseDetails
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'details')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    private Adresse $adresse;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Kunde::class, inversedBy: 'adressen')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id')]
    #[Groups([SerializerGroups::READ_ADRESSE])]
    private Kunde $kunde;

    #[ORM\Column(nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?bool $geschaeftlich = null;

    #[ORM\Column(nullable: true)]
    #[Groups([SerializerGroups::READ_COMMON])]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column]
    private bool $geloescht;


    public function getAdresse() : Adresse
    {
        return $this->adresse;
    }


    public function setAdresse(Adresse $adresse) : void
    {
        $this->adresse = $adresse;
    }


    public function getKunde() : Kunde
    {
        return $this->kunde;
    }


    public function setKunde(Kunde $kunde) : void
    {
        $this->kunde = $kunde;
    }


    public function getGeschaeftlich() : ?bool
    {
        return $this->geschaeftlich;
    }


    public function setGeschaeftlich(?bool $geschaeftlich) : void
    {
        $this->geschaeftlich = $geschaeftlich;
    }


    public function getRechnungsadresse() : ?bool
    {
        return $this->rechnungsadresse;
    }


    public function setRechnungsadresse(?bool $rechnungsadresse) : void
    {
        $this->rechnungsadresse = $rechnungsadresse;
    }


    public function isGeloescht() : bool
    {
        return $this->geloescht;
    }


    public function setGeloescht(bool $geloescht) : void
    {
        $this->geloescht = $geloescht;
    }
}
