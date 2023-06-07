<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CustomerRepository;
use App\State\CustomerPostProcessor;
use App\State\CustomersByBrokerProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class),
    ORM\Table(name: 'std.tbl_kunden')]
#[ApiResource(
    shortName: 'Kunde',
    description: 'CRUD of customer data, related to broker',
    operations: [
        new GetCollection(
            uriTemplate: '/kunden/',
            provider: CustomersByBrokerProvider::class
        ),
        new Get(
            uriTemplate: '/kunden/{id}',
            requirements: ['id' => '[A-Z\d*]{8}'],
        ),
        new Post(
            uriTemplate: '/kunden/',
            processor: CustomerPostProcessor::class,
        ),
        new Put(
            uriTemplate: '/kunden/{id}',
            requirements: ['id' => '[A-Z\d*]{8}'],
        )
    ],
    normalizationContext: ['groups' => ['kunde:read']],
    denormalizationContext: ['groups' => ['kunde:write']],
)]
class Customer
{
    private const GENDER = ['männlich', 'weiblich', 'divers'];

    /**
     * @var string|null generated alphanumeric identifier, not to be guessed by a front end user
     */
    #[ORM\Id,
        ORM\GeneratedValue(strategy: 'AUTO'),
        ORM\Column(type: Types::STRING, length: 8)
    ]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'string',
            'format' => 'uuid',
            'example' => 'A1B2C3D3',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read'])]
    private ?string $id = null;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: true)]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => 'Doe',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read', 'kunde:write'])]
    #[SerializedName('name')]
    private ?string $lastName = null;

    #[ORM\Column(name: 'vorname', type: Types::STRING, length: 255, nullable: true)]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => 'John',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read', 'kunde:write'])]
    #[SerializedName('vorname')]
    private ?string $firstName = null;

    /**
     * @var string|null employment of customer
     */
    #[ORM\Column(name: 'firma', type: Types::TEXT, nullable: true)]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'example' => 'Foo Ag',
            'required' => true
        ]
    )]
    #[Groups(['kunde:write'])]
    private ?string $companyName = null;

    #[ORM\Column(name: 'geburtsdatum', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'date',
            'example' => '1970-01-01',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read', 'kunde:write'])]
    #[SerializedName('geburtsdatum')]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(name: 'geloescht', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => 'false',
            'default' => 'false'
        ]
    )]
    #[Groups(['kunde:write'])]
    private bool $deleted = false;

    #[ORM\Column(name: 'geschlecht', type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Choice(choices: self::GENDER)]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => 'divers',
            'enum' => self::GENDER
        ]
    )]
    #[Groups(['kunde:read', 'kunde:write'])]
    #[SerializedName('geschlecht')]
    private ?string $gender = self::GENDER[2];

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
        groups: ['user:write']
    )]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'example' => 'example@example.com',
            'required' => true
        ]
    )]
    #[Groups(['kunde:read', 'kunde:write'])]
    private ?string $email = null;

    /**
     * @var Broker|null a customer only exists valid in system, in case having an allocation to one broker
     */
    #[ORM\ManyToOne(targetEntity: Broker::class, inversedBy: 'customers'),
        ORM\JoinTable(name: 'std.vermittler'),
        ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id', nullable: false)
    ]
    #[SerializedName('vermittlerId')]
    private ?Broker $broker;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: CustomerAddress::class, fetch: 'EAGER', orphanRemoval: true),
        ORM\JoinTable(name: 'std.kunde_adresse'),
        ORM\JoinColumn(name: "kunde_id", referencedColumnName: "id")
    ]
    private Collection $customerAddresses;

    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'customers', fetch: 'EAGER'),
        ORM\JoinTable(name: 'std.kunde_adresse'),
        ORM\JoinColumn(name: "kunde_id", referencedColumnName: "id"),
        ORM\InverseJoinColumn(name: "adresse_id", referencedColumnName: "adresse_id")]
    #[Groups(['kunde:read'])]
    #[SerializedName('adressen')]
    private Collection $addresses;

    #[ORM\OneToOne(mappedBy: 'customer', cascade: ['persist', 'remove'])]
    #[SerializedName('user')]
    private ?CustomerUser $customerUser = null;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->customerAddresses = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getBroker(): ?Broker
    {
        return $this->broker;
    }

    public function setBroker(?Broker $broker): self
    {
        $this->broker = $broker;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * @return Collection<int, CustomerAddress>
     */
    public function getCustomerAddresses(): Collection
    {
        return $this->customerAddresses;
    }

    public function addCustomerAddress(CustomerAddress $customerAddress): self
    {
        if (!$this->customerAddresses->contains($customerAddress)) {
            $this->customerAddresses->add($customerAddress);
            $customerAddress->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomerAddress(CustomerAddress $customerAddress): self
    {
        if ($this->customerAddresses->removeElement($customerAddress)) {
            // set the owning side to null (unless already changed)
            if ($customerAddress->getCustomer() === $this) {
                $customerAddress->setCustomer(null);
            }
        }

        return $this;
    }

    public function getCustomerUser(): ?CustomerUser
    {
        return $this->customerUser;
    }

    public function setCustomerUser(?CustomerUser $customerUser): self
    {
        // unset the owning side of the relation if necessary
        if ($customerUser === null && $this->customerUser !== null) {
            $this->customerUser->setCustomer(null);
        }

        // set the owning side of the relation if necessary
        if ($customerUser !== null && $customerUser->getCustomer() !== $this) {
            $customerUser->setCustomer($this);
        }

        $this->customerUser = $customerUser;

        return $this;
    }
}
