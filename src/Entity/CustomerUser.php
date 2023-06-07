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
use App\Repository\CustomerUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User belongs to Customer, providing login data.
 */
#[ORM\Entity(repositoryClass: CustomerUserRepository::class),
    ORM\Table(name: 'sec.user')
]
#[ApiResource(
    shortName: 'User',
    description: 'CRUD of customer user, related to customer',
    operations: [
        new GetCollection(
            uriTemplate: '/user/'
        ),
        new Get(
            uriTemplate: '/user/{id}',
            requirements: ['id' => '[\d+]'],
        ),
        new Get(
            uriTemplate: '/kunden/{id}/user',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'customerUser',
                    fromClass: Customer::class
                )
            ],
            requirements: ['id' => '[A-Z\d*]{8}'],
        ),
        new Post(
            uriTemplate: '/user/'
        ),
        new Put(
            uriTemplate: '/user/{id}',
            requirements: ['id' => '[\d+]'],
        ),
        new Delete(
            uriTemplate: '/user/{id}',
            requirements: ['id' => '[\d+]'],
        )
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
)]
class CustomerUser
{
    #[ORM\Id,
        ORM\GeneratedValue(strategy: 'IDENTITY'),
        ORM\Column(type: Types::INTEGER, nullable: false)]
    #[ApiProperty(
        identifier: true,
        openapiContext: [
            'type' => 'integer',
            'example' => '1',
            'required' => true
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
        groups: ['user:write']
    )]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => 'example@example.com',
            'required' => true
        ]
    )]
    #[Groups(['user:read', 'user:write', 'kunde:read'])]
    #[SerializedName('username')]
    private ?string $email = null;

    #[ORM\Column(name: 'passwd',length: 60)]
    #[Assert\NotBlank(groups: ['user:write']),
        Assert\Length(min: 8, groups: ['user:write']),
        Assert\Regex(pattern: '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/i', groups: ['user:write']),
    ]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'string',
            'example' => '****',
            'required' => true
        ]
    )]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\Column(name: 'aktiv', type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'boolean',
            'example' => 'true',
            'default' => 'true'
        ]
    )]
    #[Groups(['user:read', 'user:write', 'kunde:read'])]
    #[SerializedName('aktiv')]
    private ?bool $active = true;

    #[ORM\Column(name: 'last_login', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Context(normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d\TH:i:sP'])]
    #[ApiProperty(
        openapiContext: [
            'type' => 'date',
            'example' => '1970-01-01T00:00:00+00:00'
        ]
    )]
    #[Groups(['user:read', 'kunde:read'])]
    private ?\DateTimeInterface $lastLogin = null;

    #[ORM\OneToOne(inversedBy: 'customerUser', targetEntity: Customer::class, cascade: ['persist', 'remove']),
        ORM\JoinColumn(name: 'kundenid', referencedColumnName: 'id', nullable: false)
    ]
    #[ApiProperty(
        required: true,
        openapiContext: [
            'type' => 'object',
            'required' => true
        ]
    )]
    #[Groups(['user:read', 'user:write'])]
    private ?Customer $customer = null;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
