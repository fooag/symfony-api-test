<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Validation as CustomAssert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sec."user"
 *
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_BROKER')"},
 *     collectionOperations={
 *         "get"={"path"="/user"},
 *         "post"={"path"="/user"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/user/{id}",
 *          },
 *         "put"={
 *              "path"="/user/{id}",
 *          },
 *         "delete"={
 *              "path"="/user/{id}",
 *          },
 *     },
 *     normalizationContext={"groups"={"kunde_user", "kunde_user:read"}},
 *     denormalizationContext={"groups"={"kunde_user", "kunde_user:write"}},
 * )
 * @ORM\Table(name="sec.user", indexes={@ORM\Index(name="IDX_AD4FE034B8EEB71B", columns={"kundenid"})})
 * @ORM\Entity
 */
class KundeUser implements UserInterface
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
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"kunde_user", "kunde"})
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passwd", type="string", length=60, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     * @CustomAssert\PasswordConstraint
     * @Groups({"kunde_user:write"})
     */
    private $passwd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aktiv", type="integer", nullable=true)
     * @Groups({"kunde_user", "kunde"})
     */
    private $aktiv;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     * @Groups({"kunde_user:read", "kunde:read"})
     */
    private $lastLogin;

    /**
     * @var Kunde|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Kunde")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kundenid", referencedColumnName="id")
     * })
     * @Groups({"kunde_user"})
     */
    private $kunde;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(?string $passwd): void
    {
        $this->passwd = $passwd;
    }

    public function getAktiv(): ?int
    {
        return $this->aktiv;
    }

    public function setAktiv(?int $aktiv): void
    {
        $this->aktiv = $aktiv;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return Kunde
     */
    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getRoles()
    {
        return ['ROLE_CUSTOMER'];
    }

    public function getPassword()
    {
        return $this->passwd;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
}
