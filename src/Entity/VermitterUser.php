<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VermitterUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VermitterUserRepository::class)
 * @ORM\Table (name="vermittler_user")
 */
class VermitterUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $passwd;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $aktiv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login;

    /**
     * @ORM\ManyToOne(targetEntity="Vermittler")
     * @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     */
    private $vermittler;

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

    /**
     * @return mixed
     */
    public function getVermittler()
    {
        return $this->vermittler;
    }

    /**
     * @param mixed $vermittler
     * @return VermitterUser
     */
    public function setVermittler($vermittler)
    {
        $this->vermittler = $vermittler;
        return $this;
    }
}
