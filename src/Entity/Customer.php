<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Doctrine\CustomerIdGenerator;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: 'std.tbl_kunden')]
#[ORM\Index(columns: ['vermittler_id'], name: 'IDX_680E0AD091EC85B5')]
#[ORM\Entity]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: 'kunden',
        ),
        new GetCollection(
            uriTemplate: 'kunden',
        ),
        new Get(
            uriTemplate: 'kunden/{id}',
        ),
        new Put(
            uriTemplate: 'kunden/{id}',
        ),
        new Delete(
            uriTemplate: 'kunden/{id}',
        ),
    ],
)]
class Customer
{
    #[ORM\Column(name: 'id', type: 'string', length: 36, nullable: false, options: ['default' => 'upper(left((gen_random_uuid())::text, 8))'])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: CustomerIdGenerator::class)]
    private ?string $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'error.Customer.name.notBlank')]
    private ?string $name = null;

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'error.Customer.vorname.notBlank')]
    private ?string $vorname = null;

    #[ORM\Column(name: 'firma', type: 'text', nullable: true)]
    private ?string $firma = null;

    #[ORM\Column(name: 'geburtsdatum', type: 'datetime', nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Assert\NotBlank(message: 'error.Customer.geburtsdatum.notBlank')]
    private ?DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(name: 'geloescht', type: 'integer', nullable: true)]
    private ?int $geloescht = null;

    #[ORM\Column(name: 'geschlecht', type: 'string', nullable: true)]
    private ?string $geschlecht = null;

    #[ORM\Column(name: 'email', type: 'text', nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity: Broker::class, inversedBy: 'kunden')]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    private ?Broker $vermittler = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function setGeloescht(?bool $geloescht): self
    {
        $this->geloescht = $geloescht ? 1 : 0;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): self
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittlerId(): int
    {
        return $this->vermittler->getId();
    }
}
