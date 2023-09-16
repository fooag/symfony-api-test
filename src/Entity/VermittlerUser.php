<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VermittlerUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VermittlerUserRepository::class)]
class VermittlerUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private string $email;

    #[ORM\Column(name: 'passwd', length: 60)]
    private string $password; // @todo would property passwd be better?

    /**
     * @todo why has field 'aktiv' has type int in db not boolean?
     */
    #[ORM\Column]
    private bool $aktiv;

    #[ORM\OneToOne(inversedBy: 'vermittlerUser')]
    #[ORM\JoinColumn(nullable: false)]
    private Vermittler $vermittler;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isAktiv(): bool
    {
        return $this->aktiv;
    }

    public function setAktiv(bool $aktiv): self
    {
        $this->aktiv = $aktiv;

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
}
