<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\AddressRepository;
use App\State\AddressesByBrokerProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: AddressRepository::class),
    ORM\Table(name: 'std.adresse')]
#[ApiResource(
    shortName: 'Adressen',
    description: 'CRUD of customer address data, related to customer',
    operations: [
        new GetCollection(
            uriTemplate: '/adressen/',
            provider: AddressesByBrokerProvider::class
        ),
        new Get(
            uriTemplate: '/adressen/{id}',
            requirements: ['id' => '[\d+]'],
        ),
        new GetCollection(
            uriTemplate: '/kunden/{id}/adressen',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'addresses',
                    fromClass: Customer::class
                )
            ],
            requirements: ['id' => '[A-Z\d*]{8}']
        ),
        new Post(
            uriTemplate: '/adressen/',
        ),
        new Put(
            uriTemplate: '/adressen/{id}',
            requirements: ['id' => '[\d+]'],
            denormalizationContext: ['groups' => ['address:change']]
        ),
        new Delete(
            uriTemplate: '/addressen/{id}',
            requirements: ['id' => '[\d+]'],
        )
    ],
    normalizationContext: ['groups' => ['address:read']],
    denormalizationContext: ['groups' => ['address:write']],
)]
class Address
{
    #[ORM\Id,
        ORM\GeneratedValue(strategy: 'IDENTITY'),
        ORM\Column(name: 'adresse_id', type: Types::INTEGER, nullable: false)
    ]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'integer',
            'example' => '1',
            'required' => true
        ]
    )]
    #[Groups(['address:read','address:write'])]
    #[SerializedName('adresseId')]
    private ?int $id = null;

    #[ORM\Column(name: 'strasse', type: Types::TEXT, nullable: true)]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => 'Wallstreet',
            'required' => true
        ]
    )]
    #[Groups(['address:read', 'address:write', 'address:change', 'kunde:read'])]
    #[SerializedName('strasse')]
    private ?string $street = null;

    #[ORM\Column(name: 'plz', length: 10, nullable: true)]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => '12345',
            'required' => true
        ]
    )]
    #[Groups(['address:read','address:write','address:change', 'kunde:read'])]
    #[SerializedName('plz')]
    private ?string $zip = null;

    #[ORM\Column(name: 'ort', type: Types::TEXT)]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => 'Berlin',
            'required' => true
        ]
    )]
    #[Groups(['address:read','address:write', 'address:change', 'kunde:read'])]
    #[SerializedName('ort')]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: CustomerAddress::class, orphanRemoval: true),
        ORM\JoinTable(name: 'std.kunde_adresse'),
        ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')
    ]
    #[SerializedName('details')]
    private Collection $customerAddresses;

    #[ORM\ManyToMany(targetEntity: Customer::class, mappedBy: 'addresses')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id')]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'object',
            'required' => true
        ]
    )]
    #[Groups(['address:read','address:write'])]
    private Collection $customers;

    #[ORM\ManyToOne(targetEntity: State::class, cascade: ['persist']),
        ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel', nullable: false)
    ]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'required' => false,
            'example' => 'BE'
        ]
    )]
    #[Groups(['address:read','address:write', 'kunde:read'])]
    private ?State $state = null;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->customerAddresses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }


    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->addAddress($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeAddress($this);
        }

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
            $customerAddress->setAddress($this);
        }

        return $this;
    }

    public function removeCustomerAddress(CustomerAddress $customerAddress): self
    {
        if ($this->customerAddresses->removeElement($customerAddress)) {
            // set the owning side to null (unless already changed)
            if ($customerAddress->getAddress() === $this) {
                $customerAddress->setAddress(null);
            }
        }

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}
