<?php
declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\CustomerAddressRepository;
use App\State\CustomerAddressProvider;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CustomerAddressRepository::class),
    ORM\Table(name: 'std.kunde_adresse')
]
#[ApiResource(
    shortName: 'Details',
    description: 'Details of an address allocated to a customer',
    operations: [
        new Get(
            uriTemplate: '/kunden/{customerId}/adressen/{addressId}/details',
            requirements: [
                'customerId' => '[A-Z\d*]{8}',
                'addressId' => '[\d+]'
            ],
            provider: CustomerAddressProvider::class
        ),
    ],
    normalizationContext: ['groups' => ['details:read']],
    denormalizationContext: ['groups' => ['details:write']],
)]
class CustomerAddress
{
    #[ORM\Id,
        ORM\ManyToOne(targetEntity: Customer::class, fetch: 'EAGER', inversedBy: 'customerAddresses'),
        ORM\JoinColumn(name: 'kunde_id', referencedColumnName: 'id', nullable: false),
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
    private ?Customer $customer = null;

    #[ORM\Id,
        ORM\ManyToOne(targetEntity: Address::class,fetch: 'EAGER', inversedBy: 'customerAddresses'),
        ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'adresse_id', nullable: false)
    ]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'integer',
            'example' => '1',
            'required' => true
        ]
    )]
    private ?Address $address = null;

    #[ORM\Column(name: 'geschaeftlich', type: Types::BOOLEAN, nullable: false)]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => true
        ]
    )]
    #[Groups(['details:read'])]
    private ?bool $business = null;

    #[ORM\Column(name: 'rechnungsadresse', type: Types::BOOLEAN, nullable: false)]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => true
        ]
    )]
    #[Groups(['details:read'])]
    private ?bool $billing = null;

    #[ORM\Column(name: 'geloescht', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    #[Groups(['details:write'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => false
        ]
    )]
    private ?bool $deleted = null;


    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function isBusiness(): ?bool
    {
        return $this->business;
    }

    public function setBusiness(bool $business): self
    {
        $this->business = $business;

        return $this;
    }

    public function isBilling(): ?bool
    {
        return $this->billing;
    }

    public function setBilling(bool $billing): self
    {
        $this->billing = $billing;

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
}
