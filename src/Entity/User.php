<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={
 *       "groups"={"user:list"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(schema="sec")
 * @UniqueEntity("email")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"user:list", "kunden"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     message="Das Passwort muss mindestens 8 Zeichen lang sein und Groß/Kleinbuchstaben sowie mind eine Zahl und ein Sonderzeichen enthalten",
     *     pattern="/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}/"
     * )
     */
    private $passwd;

    /**
     * @ORM\ManyToOne(targetEntity="TblKunden", inversedBy="users")
     * @ORM\JoinColumn(nullable=false, name="kundenid", referencedColumnName="id")
     */
    private $kundenId;

    /**
     * @ORM\Column(type="integer", options={"default":1})
     * @Groups({"user:list", "kunden"})
     */
    private $aktiv;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user:list", "kunden"})
     */
    private $last_login;

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

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(string $passwd): self
    {
        $this->passwd = $passwd;

        return $this;
    }

    public function getAktiv(): ?int
    {
        return $this->aktiv;
    }

    public function setAktiv(int $aktiv): self
    {
        $this->aktiv = $aktiv;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function getKundenId(): ?TblKunden
    {
        return $this->kundenId;
    }

    public function setKundenId(?TblKunden $kundenId): self
    {
        $this->kundenId = $kundenId;

        return $this;
    }
}
