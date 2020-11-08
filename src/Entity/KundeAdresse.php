<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KundeAdresseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KundeAdresseRepository::class)
 * @ORM\Table(schema="std")
 */
class KundeAdresse
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36)
     */
    private $kunde_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $adresse_id;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $geschaeftlich;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rechnungsadresse;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $geloescht;

    public function getKundeId(): ?string
    {
        return $this->kunde_id;
    }

    public function setKundeId(string $kunde_id): self
    {
        $this->kunde_id = $kunde_id;

        return $this;
    }

    public function getAdresseId(): ?int
    {
        return $this->adresse_id;
    }

    public function setAdresseId(int $adresse_id): self
    {
        $this->adresse_id = $adresse_id;

        return $this;
    }

    public function getGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function getRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function getGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}
