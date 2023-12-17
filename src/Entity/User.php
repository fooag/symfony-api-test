<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\Delete\DeleteController;
use App\Controller\Get\GetController;
use App\Controller\GetCollection\UserGetCollectionController;
use App\Controller\Post\PostController;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'sec.user')]
#[ApiResource(operations: [
    new Get(
        controller: GetController::class
    ),
    new GetCollection(
        controller: UserGetCollectionController::class
    ),
    new Post(

        controller: PostController::class
    ),
    new Delete(
        controller: DeleteController::class,
        write: false
    )
],
    normalizationContext: ["groups" => ["user.read"]],
    denormalizationContext: ["groups" => ["user.write"]]
)]
class User implements PasswordAuthenticatedUserInterface, IEntity
{
    #[Groups(['user.read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Groups(['user.write', 'user.read'])]
    #[ORM\Column(length: 200, unique: true, nullable: true)]
    private ?string $email = null;

    #[Groups(['user.write'])]
    #[Assert\NotBlank]
    #[Assert\Regex(['pattern' => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/"])]
    #[ORM\Column(length: 60, nullable: true)]
    private ?string $passwd = null;

    #[Assert\NotBlank]
    #[Groups(['user.write', 'user.read'])]
    #[ORM\Column(nullable: true)]
    private ?int $aktiv = null;

    #[Groups(['user.read'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLogin = null;


    #[Groups(['user.write', 'user.read'])]
    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(name: "kundenid", referencedColumnName:"id", nullable: true)]
    private ?Kunden $kundenid = null;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->passwd;
    }

    public function getPasswd(): string
    {
        return $this->passwd;
    }
    public function setPasswd(string $password): self
    {
        $this->passwd = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getKundenid(): ?Kunden
    {
        return $this->kundenid;
    }

    public function setKundenid(?Kunden $kundenid): self
    {
        $this->kundenid = $kundenid;

        return $this;
    }
}
