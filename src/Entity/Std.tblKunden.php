<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Std;

#[ORM\Table(name: 'std.tbl_kunden')]
#[ORM\Index(name: 'IDX_680E0AD091EC85B5', columns: ['vermittler_id'])]
#[ORM\Entity]
class StdtblKunden
{
    #[ORM\Column(name: 'id', type: 'string', length: 36, nullable: false, options: ['default' => '"upper("left'])]
    private string $id;

    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(name: 'firma', type: 'text', nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(name: 'geburtsdatum', type: 'datetime', nullable: true)]
    private ?DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(name: 'geloescht', type: 'integer', nullable: true)]
    private ?int $geloescht = null;

    #[ORM\Column(name: 'geschlecht', type: 'string', nullable: true)]
    private ?string $geschlecht = null;

    #[ORM\Column(name: 'email', type: 'text', nullable: true)]
    private ?string $email = null;

    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: 'Std.vermittler')]
    private $vermittler;
}
