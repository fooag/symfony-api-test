<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Delete\DeleteController;
use App\Controller\Get\GetController;
use App\Controller\Get\KundeGetController;
use App\Controller\GetCollection\KundenGetCollectionController;
use App\Controller\Post\PostController;
use App\Repository\KundenRepository;
use App\Service\Generator\IdGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: "std.tbl_kunden")]
#[ORM\Entity(repositoryClass: KundenRepository::class)]
#[ApiResource(operations: [
    new Get(
        controller: GetController::class
    ),

    new GetCollection(
        controller: KundenGetCollectionController::class
    ),
    new Get(
        routeName: 'kunde_adressen'
    ),
    new Get(
        uriTemplate: 'foo/kunden/{id}/adressen/{adresseId}/details',
        routeName: 'kunde_adresse_details'
    ),
    new Get(
        routeName: 'kunde_users'
    ),
    new Post(
        controller: PostController::class
    ),
    new Delete(
        controller: DeleteController::class,
        write: false
    )
],
    normalizationContext: ["groups" => ["kunde.read"]],
    denormalizationContext: ["groups" => ["kunde.write"]]
)]
class Kunden implements IEntity
{
    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: IdGenerator::class)]
    #[ORM\Column(length: 36, options:["default"=> 'upper("left"((gen_random_uuid())::text, 8))'] )]
    private ?string $id = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vorname = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $firma = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $geburtsdatum = null;

    #[ORM\Column(nullable: true)]
    private ?int $geloescht = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $geschlecht = null;

    #[Groups(['kunde.read', 'kunde.write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "vermittler_id", nullable: false)]
    private ?Vermittler $vermittler = null;

    #[Groups(['kunde.write'])]
    #[ORM\OneToMany(mappedBy: 'kunde', targetEntity: KundeAdresse::class)]
    private Collection $kundeAdresses;

    #[ORM\OneToMany(mappedBy: 'kundenid', targetEntity: User::class)]
    private Collection $users;


    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->kundeAdresses = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }


    public function setId(string $id): ?string
    {
        return $this->id = $id;
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

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
    {
        $this->geloescht = $geloescht;

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

    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }

    /**
     * @return Collection<int, KundeAdresse>
     */
    public function getKundeAdresses(): Collection
    {
        return $this->kundeAdresses;
    }

    public function addKundeAdress(KundeAdresse $kundeAdress): self
    {
        if (!$this->kundeAdresses->contains($kundeAdress)) {
            $this->kundeAdresses->add($kundeAdress);
            $kundeAdress->setKunde($this);
        }

        return $this;
    }

    public function removeKundeAdress(KundeAdresse $kundeAdress): self
    {
        if ($this->kundeAdresses->removeElement($kundeAdress)) {
            // set the owning side to null (unless already changed)
            if ($kundeAdress->getKunde() === $this) {
                $kundeAdress->setKunde(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setKundenid($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getKundenid() === $this) {
                $user->setKundenid(null);
            }
        }

        return $this;
    }
}
