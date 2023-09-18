<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'sec.user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'email', length: 200)]
    #[Assert\NotBlank]
    #[Groups('kunde')]
    private ?string $username = null;

    #[ORM\Column(name: 'passwd', length: 60, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 36, nullable: true)]
    private ?string $kundenid = null;

    #[ORM\Column(nullable: true)] // @todo can it be boolean here
    #[Groups('kunde')]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', type: Types::DATETIME_MUTABLE, nullable: true)] // @todo is this type correct
    #[Groups('kunde')]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    private Kunde $kunde;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    #[Ignore]
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    #[Ignore]
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
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    #[Ignore]
    public function getKunde(): ?Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }
}
