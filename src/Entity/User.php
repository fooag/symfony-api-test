<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="sec.user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",          options={"autoincrement":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private ?string $passwd;

    /**
     * @ORM\OneToOne(targetEntity=TblKunden::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="kundenid",             nullable=false)
     */
    private TblKunden $kundenid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $aktiv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $last_login;

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

    public function getKundenid(): ?TblKunden
    {
        return $this->kundenid;
    }

    public function setKundenid(TblKunden $kundenid): self
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

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }
}
