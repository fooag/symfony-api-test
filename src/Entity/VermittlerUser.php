<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VermittlerUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: VermittlerUserRepository::class)]
#[ORM\Table(name: "sec.vermittler_user")]
class VermittlerUser implements UserInterface, PasswordAuthenticatedUserInterface, VermittlerUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, unique: true)]
    private string $email;

    #[ORM\Column(length: 60)]
    private string $passwd;

    #[ORM\Column]
    private bool $aktiv;

    #[ORM\Column(nullable: true)]
    private ?string $lastLogin = null;

    #[ORM\OneToOne(inversedBy: "vermittlerUser", targetEntity: Vermittler::class)]
    private Vermittler $vermittler;

    public function __construct(
        string $email,
        string $passwd,
        Vermittler $vermittler
    ) {
        $this->email = $email;
        $this->passwd = $passwd;
        $this->aktiv = true;
        $this->vermittler = $vermittler;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->passwd;
    }

    public function setPassword(string $password): self
    {
        $this->passwd = $password;

        return $this;
    }

    public function isAktiv(): bool
    {
        return $this->aktiv;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    public function getVermittlerId(): int
    {
        return $this->vermittler->getId();
    }

    public function eraseCredentials()
    {
        //Not needed here
    }
}
