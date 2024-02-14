<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Common\Geschlecht;
use App\Doctrine\UuidGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ORM\Table(name: "std.tbl_kunden")]
#[ApiResource(
    operations: [
        new GetCollection('/kunden'),
        new Get('/kunden/{id}'),
        new Put('/kunden/{id}'),
        new Delete('/kunden/{id}'),
        new Post('/kunden'),
    ],
    normalizationContext: ['groups' => ['customer:read'], 'serialize_null' => true],
    denormalizationContext: ['groups' => ['customer:write']],
)]
#[ApiFilter(BooleanFilter::class, properties: ['geloescht'])]
class Kunde
{
    #[ORM\Id, ORM\Column(type: 'string', length: 8)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['customer:read'])]
    private ?string $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $vorname;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $email;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?string $firma;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?\DateTime $geburtsdatum;

    #[ORM\Column(type: "geschlecht_enum", nullable: true)]
    #[Groups(['customer:read', 'customer:write'])]
    private ?Geschlecht $geschlecht;

    #[ORM\OneToMany(mappedBy: 'kunde', targetEntity: KundenAdresse::class, fetch: 'EAGER')]
    private Collection $kundenAdressen;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['customer:read'])]
    private ?int $geloescht = 0;

    #[ORM\OneToOne(mappedBy: 'kunde', targetEntity: User::class, fetch: 'EAGER')]
    #[ApiProperty("https://schema.org/User")]
    #[Groups(['customer:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Vermittler::class, inversedBy: 'kunden')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['customer:write'])]
    private ?Vermittler $vermittler = null;

    public function __construct()
    {
        $this->kundenAdressen = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
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

    public function getGeschlecht(): ?Geschlecht
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?Geschlecht $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): void
    {
        $this->geloescht = $geloescht;
    }

    public function getKundenAdressen(): Collection
    {
        return $this->kundenAdressen;
    }

    public function setKundenAdressen(Collection $kundenAdressen): void
    {
        $this->kundenAdressen = $kundenAdressen;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?Vermittler $vermittler): void
    {
        $this->vermittler = $vermittler;
    }

    #[Groups(['customer:read'])]
    public function getVermittlerId(): int
    {
        return $this->vermittler->getId();
    }

    #[Groups(['customer:read'])]
    public function getAdressen(): array
    {
        return $this->kundenAdressen->map(function (KundenAdresse $kundenAdresse) {
            $adresse = $kundenAdresse->getAdresse();

            $details = [
                'geschaeftlich' => $kundenAdresse->getGeschaeftlich(),
                'rechnungsadresse' => $kundenAdresse->getRechnungsadresse(),
            ];

            return [
                'adresseId' => $adresse->getId(),
                'strasse' => $adresse->getStrasse(),
                'plz' => $adresse->getPlz(),
                'ort' => $adresse->getOrt(),
                'bundesland' => $adresse->getBundesland(),
                'details' => $details
            ];
        })->getValues();
    }
}