<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="std.adresse")
 * @ORM\Entity()
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/adressen"},
 *         "post"={"path"="/adressen"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/adressen/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "put"={
 *              "path"="/adressen/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "delete"={
 *              "path"="/adressen/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *     },
 * )
 */
class Adresse
{
    /**
     * @var int
     *
     * @ORM\Column(name="adresse_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     */
    private $strasse;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     *
     * @Assert\NotBlank()
     */
    private $plz;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank()
     */
    private $ort;

    //TODO bundesland ?

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
    public function getStrasse(): string
    {
        return $this->strasse;
    }

    /**
     * @param string $strasse
     */
    public function setStrasse(string $strasse): void
    {
        $this->strasse = $strasse;
    }

    /**
     * @return string|null
     */
    public function getPlz(): ?string
    {
        return $this->plz;
    }

    /**
     * @param string|null $plz
     */
    public function setPlz(?string $plz): void
    {
        $this->plz = $plz;
    }

    /**
     * @return string
     */
    public function getOrt(): string
    {
        return $this->ort;
    }

    /**
     * @param string $ort
     */
    public function setOrt(string $ort): void
    {
        $this->ort = $ort;
    }
}