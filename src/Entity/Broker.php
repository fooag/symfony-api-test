<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use App\Repository\BrokerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Broker is the big guy on top, which logs in and does not see himself, but his allocated customers.
 * Can be deleted by flag.
 */
#[ORM\Entity(repositoryClass: BrokerRepository::class),
    ORM\Table(name: 'std.vermittler')]
class Broker
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'integer',
            'example' => '1000',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read'])]
    private int $id;

    /**
     * @var string generated alphanumeric identifier, not to be guessed by a front end user
     */
    #[ORM\GeneratedValue]
    private string $identification;

    #[ORM\Column(name: 'vorname', length: 255, nullable: true)]
    private ?string $prename = null;

    #[ORM\Column(name: 'nachname', length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(name: 'firma', length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(name: 'geloescht', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $deleted = false;

    /**
     * @var Collection<int, Customer>
     */
    #[ORM\OneToMany(mappedBy: 'broker', targetEntity: Customer::class, fetch: 'EAGER')]
    private Collection $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function setIdentification(string $identification): self
    {
        $this->identification = $identification;

        return $this;
    }

    public function getPrename(): ?string
    {
        return $this->prename;
    }

    public function setPrename(?string $prename): self
    {
        $this->prename = $prename;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCustomers(): Collection
    {
        return $this->customers;
    }
}
