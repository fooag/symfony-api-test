<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'sec.user')]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
#[ApiResource(
    uriTemplate: '/kunden/{id}/user',
    operations: [new GetCollection()],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'userAccount',
            fromClass: Kunde::class
        )
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    #[Groups(['read', 'write', 'kunde'])]
    private ?string $email = null;

    #[ORM\Column(length: 60, nullable: true)]
    #[Groups(['write'])]
    private ?string $passwd = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    #[Groups(['read', 'write'])]
    private ?Kunde $kundenId = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write', 'kunde'])]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', nullable: true)]
    #[Groups(['read', 'write', 'kunde'])]
    private ?\DateTimeImmutable $lastLogin = null;

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

    public function setPasswd(?string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getKundenId(): ?Kunde
    {
        return $this->kundenId;
    }

    public function setKundenId(?Kunde $kundenId): self
    {
        $this->kundenId = $kundenId;

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

    public function getLastLogin(): ?\DateTimeImmutable
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeImmutable $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }
}
