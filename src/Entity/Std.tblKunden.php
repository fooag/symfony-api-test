<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Std.tblKunden
 *
 * @ORM\Table(name="std.tbl_kunden", indexes={@ORM\Index(name="IDX_680E0AD091EC85B5", columns={"vermittler_id"})})
 * @ORM\Entity
 */
class Std.tblKunden
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, nullable=false, options={"default"="upper("left"((gen_random_uuid())::text, 8))"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="std.tbl_kunden_id_seq", allocationSize=1, initialValue=1)
     */
    private $id = 'upper("left"((gen_random_uuid())::text, 8))';

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vorname", type="string", length=255, nullable=true)
     */
    private $vorname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="text", nullable=true)
     */
    private $firma;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="geburtsdatum", type="datetime", nullable=true)
     */
    private $geburtsdatum;

    /**
     * @var int|null
     *
     * @ORM\Column(name="geloescht", type="integer", nullable=true)
     */
    private $geloescht;

    /**
     * @var string|null
     *
     * @ORM\Column(name="geschlecht", type="string", nullable=true)
     */
    private $geschlecht;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="text", nullable=true)
     */
    private $email;

    /**
     * @var \Std.vermittler
     *
     * @ORM\ManyToOne(targetEntity="Std.vermittler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     * })
     */
    private $vermittler;


}
