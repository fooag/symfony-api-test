<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Controller\Delete\DeleteController;
use App\Controller\Get\GetController;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: "std.kunde_adresse")]
#[ORM\Entity(repositoryClass: KundeAdresseRepository::class)]

class KundeAdresse
{
    #[Groups(['kunde.write'])]
    #[ORM\Column(nullable: true, options:["default"=> false])]
    private ?bool $geschaeftlich = null;

    #[Groups(['kunde.write'])]
    #[ORM\Column(nullable: true)]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column(options:["default"=> false])]
    private ?bool $geloescht = null;

    #[Groups(['kunde.write'])]
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'kundeAdresses')]
    #[ORM\JoinColumn(referencedColumnName:"adresse_id", nullable: false)]
    private ?Adresse $adresse = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'kundeAdresses', cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Kunden $kunde = null;


    public function isGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(?bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getKunde(): ?Kunden
    {
        return $this->kunde;
    }

    public function setKunde(?Kunden $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }
}
