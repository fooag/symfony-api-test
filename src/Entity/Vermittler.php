<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VermittlerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     attributes={
 *         "formats"={"jsonld"}
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *              "normalization_context"={
 *                 "groups"={"vermittler:get"},
 *             }
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "denormalization_context"={
 *                 "groups"={"vermittler:put"},
 *             }
 *         }
 *     },
 *     collectionOperations={
 *         "get"={
 *             "method"="GET",
 *             "path"="/foo/kunden",
 *             "normalization_context"={
 *                 "groups"={"vermittler:get"},
 *             }
 *         },
 *         "post"={
 *             "method"="POST",
 *             "path"="/foo/kunden",
 *             "denormalization_context"={
 *                 "groups"={"vermittler:post"},
 *             }
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass=VermittlerRepository::class)
 * @ORM\Table(name="std.vermittler")
 */
class Vermittler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=36)
     */
    private $nummer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vorname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nachname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @ORM\Column(type="boolean")
     */
    private $geloescht = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

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

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

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
