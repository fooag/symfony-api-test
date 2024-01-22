<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'sec.vermittler_user')]
#[ORM\Index(name: 'IDX_222EB99D91EC85B5', columns: ['vermittler_id'])]
#[ORM\Entity]
class SecvermittlerUser
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'sec.vermittler_user_id_seq', allocationSize: 1, initialValue: 1)]
    private ?int $id = 0;

    #[ORM\Column(name: 'email', type: 'string', length: 200, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd', type: 'string', length: 60, nullable: true)]
    private ?string $passwd = null;

    #[ORM\Column(name: 'aktiv', type: 'integer', nullable: true)]
    private ?int $aktiv = null;

    #[ORM\Column(name: 'last_login', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: 'Std.vermittler')]
    private $vermittler;
}
