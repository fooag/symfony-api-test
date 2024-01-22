<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Std.vermittler
 *
 * @ORM\Table(name="std.vermittler")
 * @ORM\Entity
 */
class Std.vermittler
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="std.vermittler_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nummer", type="string", length=36, nullable=false, options={"default"="upper("left"((gen_random_uuid())::text, 8))"})
     */
    private $nummer = 'upper("left"((gen_random_uuid())::text, 8))';

    /**
     * @var string|null
     *
     * @ORM\Column(name="vorname", type="string", length=255, nullable=true)
     */
    private $vorname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nachname", type="string", length=255, nullable=true)
     */
    private $nachname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="string", length=255, nullable=true)
     */
    private $firma;

    /**
     * @var bool
     *
     * @ORM\Column(name="geloescht", type="boolean", nullable=false)
     */
    private $geloescht = false;


}
