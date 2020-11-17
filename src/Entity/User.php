<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sec.user")
 * @ORM\Entity()
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/user"},
 *         "post"={"path"="/user"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/user/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "put"={
 *              "path"="/user/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *         "delete"={
 *              "path"="/user/{id}",
 *              "requirements"={"id"="\d+"},
 *          },
 *     },
 * )
 */
class User
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
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     */
    private $passwd;

//    /**
//     * @var Kunde
//     *
//     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Kunde", inversedBy="user")
//     */
//    private $kunde;
    //TODO

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $aktiv;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */
    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    /**
     * @return int
     */
    public function getAktiv(): int
    {
        return $this->aktiv;
    }

    /**
     * @param int $aktiv
     */
    public function setAktiv(int $aktiv): void
    {
        $this->aktiv = $aktiv;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime|null $lastLogin
     */
    public function setLastLogin(?\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }
}