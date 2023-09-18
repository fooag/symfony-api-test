<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Constraints as CustomAssert;

#[ORM\Table(name: 'sec.user')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new Get(uriTemplate: '/user/{id}'),
        new Put(uriTemplate: '/user/{id}'),
        new Delete(uriTemplate: '/user/{id}'),
        new Post(uriTemplate: '/user'),
        new GetCollection(uriTemplate: '/user'),
    ],
    normalizationContext: ['groups' => ['reading']],
    denormalizationContext: ['groups' => ['writing']]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'email', length: 200)]
    #[Assert\NotBlank]
    #[Groups(['kunde', 'reading', 'writing'])]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $username = null;

    #[ORM\Column(name: 'passwd', length: 60, nullable: true)]
    #[Groups(['writing'])]
    #[CustomAssert\PasswordConstraint]
    private ?string $password = null;

    #[ORM\Column(length: 36, nullable: true)]
    #[Groups(['reading', 'writing'])]
    private ?string $kundenid = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['reading', 'writing', 'kunde'])]
    #[Assert\Choice(choices: [0, 1])]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reading', 'kunde'])]
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
