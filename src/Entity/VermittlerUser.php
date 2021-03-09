<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Sec.vermittlerUser
 *
 * @ORM\Table(name="sec.vermittler_user", indexes={@ORM\Index(name="IDX_222EB99D91EC85B5", columns={"vermittler_id"})})
 * @ORM\Entity
 */
class VermittlerUser implements UserInterface
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
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passwd", type="string", length=60, nullable=true)
     */
    private $passwd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aktiv", type="integer", nullable=true)
     */
    private $aktiv;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vermittler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     * })
     */
    private $vermittler;

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

    public function getVermittler(): Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(Vermittler $vermittler): void
    {
        $this->vermittler = $vermittler;
    }

    public function getRoles()
    {
        return ['ROLE_BROKER'];
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
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
    }
}
