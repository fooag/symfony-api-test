<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Std.tblKunden
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"path"="/kunden"},
 *         "post"={"path"="/kunden", "security_post_denormalize" = "is_granted('ROLE_BROKER')"}
 *     },
 *     itemOperations={
 *         "get"={
 *              "path"="/kunden/{id}",
 *          },
 *         "put"={
 *              "path"="/kunden/{id}",
 *          },
 *         "delete"={
 *              "path"="/kunden/{id}",
 *          },
 *     },
 *     normalizationContext={"groups"={"kunde", "kunde:read"}},
 *     denormalizationContext={"groups"={"kunde", "kunde:write"}},
 * )
 * @ORM\Table(name="std.tbl_kunden", indexes={@ORM\Index(name="IDX_680E0AD091EC85B5", columns={"vermittler_id"})})
 * @ORM\Entity
 */
class Kunde implements SoftDeletable
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=36, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"kunde"})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vorname", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"kunde"})
     */
    private $vorname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firma", type="text", nullable=true)
     * @Groups({"kunde"})
     */
    private $firma;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="geburtsdatum", type="datetime", nullable=true)
     * @Assert\NotBlank()
     * @Groups({"kunde"})
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
     * @ORM\Column(name="geschlecht", type="geschlecht", nullable=true)
     * @Groups({"kunde"})
     */
    private $geschlecht;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="text", nullable=true)
     * @Groups({"kunde"})
     */
    private $email;

    /**
     * @var Vermittler
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Vermittler")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     * })
     */
    private $vermittler;

    /**
     * @var Collection<KundenAdressenRelation>
     *
     * @ORM\OneToMany(targetEntity="KundenAdressenRelation", mappedBy="kunde")
     * @Groups({"kunde"})
     */
    private $adressenRelations;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\KundeUser", mappedBy="kunde")
     * @ORM\JoinTable(name="sec.user",
     *      joinColumns={@ORM\JoinColumn(name="kundenid", referencedColumnName="id")},
     * )
     * @ApiSubresource()
     * @Groups({"kunde"})
     */
    private $user;

    public function __construct()
    {
        $this->adressenRelations = new ArrayCollection([]);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): void
    {
        $this->firma = $firma;
    }

    public function getGeburtsdatum(): ?\DateTime
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTime $geburtsdatum): void
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): void
    {
        $this->geloescht = $geloescht;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getVermittler(): Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(Vermittler $vermittler): void
    {
        $this->vermittler = $vermittler;
    }

    /**
     * @Groups({"kunde"})
     */
    public function getVermittlerId(): int
    {
        return $this->getVermittler()->getId();
    }

    /**
     * @Groups({"kunde"})
     * @ApiSubresource()
     */
    public function getAdressen(): array
    {
        $addressesWithDetails = [];

        /** @var KundenAdressenRelation $adressMeta */
        foreach ($this->adressenRelations as $addressMeta) {
            $address = $addressMeta->getAdresse();
            // TODO: use serializer & merge details
            $addressesWithDetails[] = [
                'strasse'    => $address->getStrasse(),
                'plz'        => $address->getPlz(),
                'ort'        => $address->getOrt(),
                'bundesland' => $address->getBundesland(),
                'details'    => [
                        'geschaeftlich'    => (bool) $addressMeta->getGeschaeftlich(),
                        'rechnungsadresse' => (bool) $addressMeta->getRechnungsadresse(),
                    ]
                ];
        }

        return $addressesWithDetails;
    }

    /**
     * @return KundeUser|null
     */
    public function getUser(): KundeUser
    {
        return $this->user;
    }

    /**
     * @param KundeUser $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
