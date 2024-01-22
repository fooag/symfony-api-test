<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'std.adresse')]
#[ORM\Index(columns: ['bundesland'], name: 'IDX_40A5D758593BEEEC')]
#[ORM\Entity]
class Stdadresse
{
    #[ORM\Column(name: 'adresse_id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\SequenceGenerator(sequenceName: 'std.adresse_adresse_id_seq', allocationSize: 1, initialValue: 1)]
    private int $adresseId;

    #[ORM\Column(name: 'strasse', type: 'text', nullable: true)]
    private ?string $strasse = null;

    #[ORM\Column(name: 'plz', type: 'string', length: 10, nullable: true)]
    private ?string $plz = null;

    #[ORM\Column(name: 'ort', type: 'text', nullable: true)]
    private ?string $ort = null;

    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    #[ORM\ManyToOne(targetEntity: 'Bundesland')]
    private Bundesland $bundesland;
}
