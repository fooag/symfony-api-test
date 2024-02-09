<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "sec.user")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'email', type: 'string', length: 200, nullable: true)]
    #[Assert\Email]
    #[Groups(['customer:read'])]
    private string $username;

    #[ORM\Column(type: 'string', length: 60, nullable: true)]
    private string $passwd;

    #[ORM\OneToOne(inversedBy: 'user', targetEntity: Kunde::class)]
    #[ORM\JoinColumn(name: "kundenid", referencedColumnName: "id", nullable: true)]
    #[ApiProperty("https://schema.org/Kunde")]
    private Kunde $kunde;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['customer:read'])]
    private int $aktiv;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['customer:read'])]
    private ?\DateTime $lastLogin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPasswd(): string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): void
    {
        $this->passwd = $passwd;
    }

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getAktiv(): int
    {
        return $this->aktiv;
    }

    public function setAktiv(int $aktiv): void
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
}
