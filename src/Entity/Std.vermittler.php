<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'std.vermittler')]
#[ORM\Entity]
class Stdvermittler
{
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'std.vermittler_id_seq', allocationSize: 1, initialValue: 1)]
    private int $id;

    #[ORM\Column(name: 'nummer', type: 'string', length: 36, nullable: false, options: ['default' => '"upper("left'])]
    private ?string $nummer = 'upper("left"((gen_random_uuid())::text, 8))';

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private ?string $vorname = null;

    #[ORM\Column(name: 'nachname', type: 'string', length: 255, nullable: true)]
    private ?string $nachname = null;

    #[ORM\Column(name: 'firma', type: 'string', length: 255, nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: false)]
    private bool $geloescht = false;
}
