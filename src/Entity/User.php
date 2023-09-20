<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'sec.user')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private string $email;

    #[ORM\Column(length: 60)]
    private string $passwd;

    #[ORM\Column]
    private int $aktiv;

    #[ORM\Column]
    private string $lastLogin;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    private Kunde $kunde;

    public function __construct(
        string $email,
        string $passwd
    ) {
        $this->email = $email;
        $this->passwd = password_hash($passwd, PASSWORD_BCRYPT);
    }

    #[Ignore]
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    #[Ignore]
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    public function getAktiv(): int
    {
        return $this->aktiv;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }
    #[Ignore]
    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): self
    {
        $this->kunde = $kunde;

        return $this;
    }
}
