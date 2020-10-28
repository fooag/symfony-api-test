<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KundeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={
 *         "formats"={"jsonld"}
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
*              "normalization_context"={
*                 "groups"={"customer:get"},
*             }
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "denormalization_context"={
 *                 "groups"={"customer:put"},
 *             }
 *         }
 *     },
 *     collectionOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/foo/kunden",
 *             "normalization_context"={
 *                 "groups"={"customer:get"},
 *             }
 *         },
 *         "post"={
 *             "method"="POST",
 *             "path"="/foo/kunden",
 *             "denormalization_context"={
 *                 "groups"={"customer:post"},
 *             }
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass=KundeRepository::class)
 * @ORM\Table(name="std.tbl_kunden")
 */
class Kunde
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "customer:write"})
     */
    private $vorname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customer:read", "customer:write"})
     */
    private $nachname;

    /**
     * @ORM\Column(type="date")
     * @Groups({"customer:read", "customer:write"})
     */
    private $geburtsdatum;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @ORM\Column(type="integer")
     */
    private $geloescht = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $geschlecht;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="Vermittler")
     * @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     */
    private $vermittler;

    /**
     * @ORM\OneToMany(targetEntity=KundeAdresse::class, mappedBy="kunde", orphanRemoval=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=KundeAdresse::class, mappedBy="kunde", orphanRemoval=true)
     */
    private $kundeAdresses;

    public function __construct()
    {
        $this->geschaeftlich = new ArrayCollection();
        $this->kundeAdresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * @param mixed $firma
     * @return Kunde
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;
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
     * @return Kunde
     */
    public function setGeloescht(bool $geloescht): Kunde
    {
        $this->geloescht = $geloescht;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeschlecht()
    {
        return $this->geschlecht;
    }

    /**
     * @param mixed $geschlecht
     * @return Kunde
     */
    public function setGeschlecht($geschlecht)
    {
        $this->geschlecht = $geschlecht;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Kunde
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVermittler()
    {
        return $this->vermittler;
    }

    /**
     * @param mixed $vermittler
     * @return Kunde
     */
    public function setVermittler($vermittler)
    {
        $this->vermittler = $vermittler;
        return $this;
    }

    /**
     * @return Collection|KundeAdresse[]
     */
    public function getGeschaeftlich(): Collection
    {
        return $this->geschaeftlich;
    }

    /**
     * @param KundeAdresse $adresse
     * @return $this
     */
    public function addAdresse(KundeAdresse $adresse): self
    {
        if (!$this->adresse->contains($adresse)) {
            $this->adresse[] = $adresse;
            $adresse->setKunde($this);
        }

        return $this;
    }

    /**
     * @param KundeAdresse $adresse
     * @return $this
     */
    public function removeAdresse(KundeAdresse $adresse): self
    {
        if ($this->adresse->removeElement($adresse)) {
            // set the owning side to null (unless already changed)
            if ($adresse->getKunde() === $this) {
                $adresse->setKunde(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|KundeAdresse[]
     */
    public function getKundeAdresses(): Collection
    {
        return $this->kundeAdresses;
    }

    public function addKundeAdress(KundeAdresse $kundeAdress): self
    {
        if (!$this->kundeAdresses->contains($kundeAdress)) {
            $this->kundeAdresses[] = $kundeAdress;
            $kundeAdress->setKunde($this);
        }

        return $this;
    }

    public function removeKundeAdress(KundeAdresse $kundeAdress): self
    {
        if ($this->kundeAdresses->removeElement($kundeAdress)) {
            // set the owning side to null (unless already changed)
            if ($kundeAdress->getKunde() === $this) {
                $kundeAdress->setKunde(null);
            }
        }

        return $this;
    }
}
