<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KundeAdresseRepository::class)]
#[ORM\Table(name: 'std.kunde_adresse')]
class KundeAdresse
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Kunde::class, inversedBy: 'kundeAdressen')]
    #[ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id')]
    private Kunde $kundenId;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Adresse::class)]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    private Adresse $adressenId;

    #[Groups('kunde')]
    #[ORM\Column(nullable: true)]
    private ?bool $geschaeftlich = null;

    #[Groups('kunde')]
    #[ORM\Column(nullable: true)]
    private ?bool $rechnungsadresse = null;

    #[ORM\Column(nullable: false)]
    private bool $geloescht;

    /**
     * @return Kunde
     */
    public function getKundenId(): Kunde
    {
        return $this->kundenId;
    }

    /**
     * @param Kunde $kundenId
     */
    public function setKundenId(Kunde $kundenId): void
    {
        $this->kundenId = $kundenId;
    }

    /**
     * @return Adresse
     */
    public function getAdressenId(): Adresse
    {
        return $this->adressenId;
    }

    /**
     * @param Adresse $adressenId
     */
    public function setAdressenId(Adresse $adressenId): void
    {
        $this->adressenId = $adressenId;
    }

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

    /**
     * @return bool
     */
    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    /**
     * @param bool $geloescht
     */
    public function setGeloescht(bool $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}
