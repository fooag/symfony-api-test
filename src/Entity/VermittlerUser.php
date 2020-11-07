<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VermittlerUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VermittlerUserRepository::class)
 * @ORM\Table(schema="sec")
 */
class VermittlerUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $passwd;

    /**
     * @ORM\ManyToOne(targetEntity="Vermittler", inversedBy="vermittlerUsers")
     * @ORM\JoinColumn(nullable=false, name="vermittler_id", referencedColumnName="id")
     */
    private $vermittlerId;

    /**
     * @ORM\Column(type="integer", options={"default":1})
     */
    private $aktiv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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

    public function getVermittlerId(): ?Vermittler
    {
        return $this->vermittlerId;
    }

    public function setVermittlerId(int $vermittlerId): self
    {
        $this->vermittlerId = $vermittlerId;

        return $this;
    }
}
