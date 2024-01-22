<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sec.user
 *
 * @ORM\Table(name="sec.user", indexes={@ORM\Index(name="IDX_C235CF9CB8EEB71B", columns={"kundenid"})})
 * @ORM\Entity
 */
class Sec.user
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sec.user_id_seq", allocationSize=1, initialValue=1)
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
     * @var \Std.tblKunden
     *
     * @ORM\ManyToOne(targetEntity="Std.tblKunden")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kundenid", referencedColumnName="id")
     * })
     */
    private $kundenid;


}
