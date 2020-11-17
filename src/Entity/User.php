<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Validator\Constraints\PasswordConstraint;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

// TODO: use groups to normalize/denormalize to hide password
// *     normalizationContext={"groups"={"read"}},
// *     denormalizationContext={"groups"={"write"}},

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
     *
     * @Groups({"read"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200)
     *
     * @Groups({"read", "write"})
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=60)
     *
     * @Groups({"write"})
     *
     * @Assert\NotBlank()
     * @PasswordConstraint()
     */
    private $passwd;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Groups({"read", "write"})
     */
    private $aktiv;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups({"read", "write"})
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