<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VermittlerUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: "sec.vermittler_user")]
#[ORM\Entity(repositoryClass: VermittlerUserRepository::class)]

class VermittlerUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(nullable: true)]
    private ?int $aktiv = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vermittler $vermittler = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function getPassword(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(?string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getAktiv(): ?int
    {
        return $this->aktiv;
    }

    public function setAktiv(?int $aktiv): self
    {
        $this->aktiv = $aktiv;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }
    
        /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
       return [];
    }
    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
        /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}
