<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sec.vermittlerUser
 *
 * @ORM\Table(name="sec.vermittler_user", indexes={@ORM\Index(name="IDX_222EB99D91EC85B5", columns={"vermittler_id"})})
 * @ORM\Entity
 */
class Sec.vermittlerUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sec.vermittler_user_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="passwd", type="string", length=60, nullable=true)
     */
    private $passwd;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aktiv", type="integer", nullable=true)
     */
    private $aktiv;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

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
