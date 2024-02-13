<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: "sec.vermittler_user")]
class VermittlerUser implements JWTUserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 200, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 60, unique: true)]
    private string $passwd;
    private array $roles = [];

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function createFromPayload($username, array $payload): self
    {
        return new self(
            $username,
            $payload['roles'], // Added by default
        );
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->passwd;
    }
}