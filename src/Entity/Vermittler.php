<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Std.vermittler
 *
 * @ORM\Table(name="std.vermittler")
 * @ORM\Entity
 */
class Vermittler implements SoftDeletable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nummer", type="string", length=36, nullable=false)
     */
    private $nummer;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vorname", type="string", length=255, nullable=true)
     */
    private $vorname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nachname", type="string", length=255, nullable=true)
     */
    private $nachname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @var bool
     *
     * @ORM\Column(name="geloescht", type="boolean", nullable=false)
     */
    private $geloescht = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNummer(): string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): void
    {
        $this->nummer = $nummer;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): void
    {
        $this->nachname = $nachname;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): void
    {
        $this->firma = $firma;
    }

    public function isGeloescht(): bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}
