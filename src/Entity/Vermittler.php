<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="std.vermittler")
 * @ORM\Entity()
 */
class Vermittler
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36, nullable=false)
     */
    private $nummer;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $vorname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $nachname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firma;

    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $geloescht;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNummer(): string
    {
        return $this->nummer;
    }

    /**
     * @param string $nummer
     */
    public function setNummer(string $nummer): void
    {
        $this->nummer = $nummer;
    }

    /**
     * @return string
     */
    public function getVorname(): string
    {
        return $this->vorname;
    }

    /**
     * @param string $vorname
     */
    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    /**
     * @return string
     */
    public function getNachname(): string
    {
        return $this->nachname;
    }

    /**
     * @param string $nachname
     */
    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    /**
     * @return string
     */
    public function getFirma(): string
    {
        return $this->firma;
    }

    /**
     * @param string $firma
     */
    public function setFirma(string $firma): void
    {
        $this->firma = $firma;
    }

    /**
     * @return string
     */
    public function getGeloescht(): string
    {
        return $this->geloescht;
    }

    /**
     * @param string $geloescht
     */
    public function setGeloescht(string $geloescht): void
    {
        $this->geloescht = $geloescht;
    }
}