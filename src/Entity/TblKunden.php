<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\KundenAdressenController;
use App\Controller\KundenAdressenDetailsController;
use App\Controller\KundenUserController;
use App\Repository\TblKundenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/kunden.{_format}"},
 *         "post"={"path"="/kunden.{_format}"},
 *     },
 *     itemOperations={
 *         "get" = {"path"="/kunden/{id}.{_format}"},
 *         "put" = {"path"="/kunden/{id}.{_format}"},
 *         "delete" = {"path"="/kunden/{id}.{_format}"},
 *         "get_adressen": {
 *             "method": "GET",
 *             "path": "/kunden/{id}/adressen.{_format}",
 *             "controller": KundenAdressenController::class
 *         },
 *         "get_adressen_details": {
 *             "method": "GET",
 *             "path": "/kunden/{id}/adressen/{adress_id}/details.{_format}",
 *             "controller": KundenAdressenDetailsController::class
 *         },
 *         "get_user": {
 *             "method": "GET",
 *             "path": "/kunden/{id}/user.{_format}",
 *             "controller": KundenUserController::class
 *         }
 *     },
 * )
 *
 * @ORM\Entity(repositoryClass=TblKundenRepository::class)
 * @ORM\Table(name="std.tbl_kunden")
 */
class TblKunden
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string",           options={"autoincrement":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $vorname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $firma;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $geburtsdatum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $geloescht;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $geschlecht;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\ManyToOne(targetEntity=Vermittler::class, inversedBy="tblKundens")
     * @ORM\JoinColumn(name="vermittler_id",          nullable=false)
     */
    private ?Vermittler $vermittler_id;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
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

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
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

    public function getVermittlerId(): ?Vermittler
    {
        return $this->vermittler_id;
    }

    public function setVermittlerId(?Vermittler $vermittler_id): self
    {
        $this->vermittler_id = $vermittler_id;

        return $this;
    }
}
