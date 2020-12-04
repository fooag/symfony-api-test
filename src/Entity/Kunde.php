<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\KundeRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/kunden"},
 *         "post"={"path"="/kunden"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/kunden/{id}",
 *          },
 *         "put"={
 *              "path"="/kunden/{id}",
 *          },
 *         "delete"={
 *              "path"="/kunden/{id}",
 *          },
 *     },
 * )
 * @ORM\Table(schema="std", name="`tbl_kunden`")
 * @ORM\Entity(repositoryClass=KundeRepository::class)
 */
class Kunde
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $vorname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank
     */
    private $geburtsdatum;

    /**
     * @ORM\Column(type="boolean")
     */
    private $geloescht;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $geschlecht;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", name="`vermittler_id`")
     */
    private $vermittler_id;

    /**
     * @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="App\Entity\Vermittler")
     */
    private $vermittler;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Adresse")
     * @ORM\JoinTable(name="kunde_adresse", schema="std",
     *      joinColumns={@ORM\JoinColumn(name="kunde_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adresse_id", referencedColumnName="adresse_id")}
     *      )
     * @ApiSubresource()
     */
    private $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

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

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): self
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittlerId(): ?int
    {
        return $this->vermittler_id;
    }

    public function setVermittlerId(int $vermittler_id): self
    {
        $this->vermittler_id = $vermittler_id;

        return $this;
    }

    public function getAdresse(): ?int
    {
        return $this->adresse;
    }

    public function setAdresse(int $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Vermittler
     */
    public function getVermittler(): Vermittler
    {
        return $this->vermittler;
    }

    /**
     * @param Vermittler $vermittler
     */
    public function setVermittler(Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }
}
