<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sec.user')]
class User
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd')]
    private ?string $passwordHash = null;

    #[ORM\ManyToOne(targetEntity: Kunde::class), ORM\JoinColumn(name: 'kundenid')]
    private ?Kunde $kunde = null;

    #[ORM\Column]
    private int $aktiv = 0;

    #[ORM\Column(name: 'last_login', type: 'datetime')]
    private ?DateTimeImmutable $lastLogin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(?string $passwordHash): User
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(?Kunde $kunde): User
    {
        $this->kunde = $kunde;
        return $this;
    }

    public function isAktiv(): bool
    {
        return (bool) $this->aktiv;
    }

    public function setAktiv(bool $aktiv): User
    {
        $this->aktiv = (int) $aktiv;
        return $this;
    }

    public function getLastLogin(): ?DateTimeImmutable
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeImmutable $lastLogin): User
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }
}
