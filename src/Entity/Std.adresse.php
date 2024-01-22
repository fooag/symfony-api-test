<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Std.adresse
 *
 * @ORM\Table(name="std.adresse", indexes={@ORM\Index(name="IDX_40A5D758593BEEEC", columns={"bundesland"})})
 * @ORM\Entity
 */
class Std.adresse
{
    /**
     * @var int
     *
     * @ORM\Column(name="adresse_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="std.adresse_adresse_id_seq", allocationSize=1, initialValue=1)
     */
    private $adresseId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="strasse", type="text", nullable=true)
     */
    private $strasse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plz", type="string", length=10, nullable=true)
     */
    private $plz;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ort", type="text", nullable=true)
     */
    private $ort;

    /**
     * @var \Bundesland
     *
     * @ORM\ManyToOne(targetEntity="Bundesland")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bundesland", referencedColumnName="kuerzel")
     * })
     */
    private $bundesland;


}
