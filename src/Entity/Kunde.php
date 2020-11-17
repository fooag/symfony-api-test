<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="std.tbl_kunden")
 * @ORM\Entity()
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/kunden"},
 *         "post"={"path"="/kunden"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/kunden/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "put"={
 *              "path"="/kunden/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "delete"={
 *              "path"="/kunden/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *     },
 * )
 */
class Kunde
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
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    private $vorname;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $firma;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     */
    private $geburtsdatum;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $geloescht;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $geschlecht;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var Vermittler|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Vermittler")
     */
    private $vermittler;

    //TODO: add user

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * @return string|null
     */
    public function getFirma(): ?string
    {
        return $this->firma;
    }

    /**
     * @param string|null $firma
     */
    public function setFirma(?string $firma): void
    {
        $this->firma = $firma;
    }

    /**
     * @return \DateTime
     */
    public function getGeburtsdatum(): \DateTime
    {
        return $this->geburtsdatum;
    }

    /**
     * @param \DateTime $geburtsdatum
     */
    public function setGeburtsdatum(\DateTime $geburtsdatum): void
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    /**
     * @return int
     */
    public function getGeloescht(): int
    {
        return $this->geloescht;
    }

    /**
     * @param int $geloescht
     */
    public function setGeloescht(int $geloescht): void
    {
        $this->geloescht = $geloescht;
    }

    /**
     * @return int|null
     */
    public function getGeschlecht(): ?int
    {
        return $this->geschlecht;
    }

    /**
     * @param int|null $geschlecht
     */
    public function setGeschlecht(?int $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Vermittler|null
     */
    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    /**
     * @param Vermittler|null $vermittler
     */
    public function setVermittler(?Vermittler $vermittler): void
    {
        $this->vermittler = $vermittler;
    }
}