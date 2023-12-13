<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'sec.vermittler_user')]
class VermittlerUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd')]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Vermittler::class)]
    private Vermittler $vermittler;

    #[ORM\Column]
    private int $aktiv = 0;

    #[ORM\Column(name: 'last_login', type: 'datetime')]
    private ?DateTime $lastLogin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): VermittlerUser
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): VermittlerUser
    {
        $this->password = $password;
        return $this;
    }

    public function getVermittler(): Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;
        return $this;
    }

    public function isAktiv(): bool
    {
        return (bool) $this->aktiv;
    }

    public function setAktiv(bool $aktiv): VermittlerUser
    {
        $this->aktiv = (int) $aktiv;
        return $this;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): VermittlerUser
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
    }
}
