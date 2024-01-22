<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bundesland
 *
 * @ORM\Table(name="bundesland")
 * @ORM\Entity
 */
class Bundesland
{
    /**
     * @var string
     *
     * @ORM\Column(name="kuerzel", type="string", length=2, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bundesland_kuerzel_seq", allocationSize=1, initialValue=1)
     */
    private $kuerzel;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;


}
