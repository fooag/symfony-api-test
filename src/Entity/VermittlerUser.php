<?php

namespace App\Entity;

use App\Repository\VermittlerUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VermittlerUserRepository::class)
 * @ORM\Table(name="sec.vermittler_user")
 */
class VermittlerUser
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
     * @ORM\OneToOne(targetEntity=Vermittler::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="vermittler_id",         nullable=false)
     */
    private Vermittler $vermittler_id;

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

    public function getVermittlerId(): ?Vermittler
    {
        return $this->vermittler_id;
    }

    public function setVermittlerId(Vermittler $vermittler_id): self
    {
        $this->vermittler_id = $vermittler_id;

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
