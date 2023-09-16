<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sec.user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd', length: 60, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $kundenid = null;

    #[ORM\Column(nullable: true)] // @todo can it be boolean here
    private ?int $aktiv = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)] // @todo is this type correct
    private ?DateTimeInterface $last_login = null;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getKundenid(): ?string
    {
        return $this->kundenid;
    }

    public function setKundenid(?string $kundenid): self
    {
        $this->kundenid = $kundenid;

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

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }
}
