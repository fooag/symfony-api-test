<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sec.vermittler_user')]
#[ORM\Index(columns: ['vermittler_id'], name: 'IDX_222EB99D91EC85B5')]
#[ORM\Entity]
class BrokerUser
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    private ?int $id = 0;

    #[ORM\Column(name: 'email', type: 'string', length: 200, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd', type: 'string', length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(name: 'aktiv', type: 'integer', nullable: true)]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: Broker::class)]
    private $vermittler;

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

    public function getVermittler()
    {
        return $this->vermittler;
    }

    public function setVermittler($vermittler): void
    {
        $this->vermittler = $vermittler;
    }
}
