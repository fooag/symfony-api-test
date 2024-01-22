<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sec.user')]
#[ORM\Index(columns: ['kundenid'], name: 'IDX_C235CF9CB8EEB71B')]
#[ORM\Entity]
class User
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'sec.user_id_seq', allocationSize: 1, initialValue: 1)]
    private ?int $id = 0;

    #[ORM\Column(name: 'email', type: 'string', length: 200, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd', type: 'string', length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(name: 'aktiv', type: 'integer', nullable: true)]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: Customer::class)]
    private $kundenid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPasswd(): ?string
    {
        return $this->passwd;
    }

    public function setPasswd(?string $passwd): void
    {
        $this->passwd = $passwd;
    }

    public function getAktiv(): ?int
    {
        return $this->aktiv;
    }

    public function setAktiv(?int $aktiv): void
    {
        $this->aktiv = $aktiv;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeInterface $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function getKundenid()
    {
        return $this->kundenid;
    }

    public function setKundenid($kundenid): void
    {
        $this->kundenid = $kundenid;
    }
}
