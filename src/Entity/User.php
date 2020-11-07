<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={
 *       "groups"={"list"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(schema="sec")
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
     * @Groups({"list"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $passwd;

    /**
     * @ORM\ManyToOne(targetEntity="TblKunden", inversedBy="users")
     * @ORM\JoinColumn(nullable=false, name="kundenid", referencedColumnName="id")
     */
    private $kundenId;

    /**
     * @ORM\Column(type="integer", options={"default":1})
     * @Groups({"list"})
     */
    private $aktiv;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"list"})
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

    public function setKundenId(int $kundenId): self
    {
        $this->kundenId = $kundenId;

        return $this;
    }
}
