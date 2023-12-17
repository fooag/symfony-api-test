<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\Delete\DeleteController;
use App\Controller\Get\GetController;
use App\Controller\GetCollection\AdresseGetCollectionController;
use App\Controller\Post\PostController;
use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Table(name: "std.adresse")]
#[ORM\Entity(repositoryClass: AdresseRepository::class)]
#[ApiResource(operations: [
    new Get(
        controller: GetController::class
    ),
    new GetCollection(
        controller: AdresseGetCollectionController::class
    ),
    new Post(
        controller: PostController::class
    ),
    new Delete(
        controller: DeleteController::class,
        write: false
    ),
    new Put()
],
    normalizationContext: ["groups" => ["adresse.read"]],
    denormalizationContext: ["groups" => ["adresse.write"]]
      )]
class Adresse implements IEntity
{
    #[Groups(['adresse.read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")]
    #[ORM\Column(name: 'adresse_id')]
    private ?string $id = null;

    #[Groups(['adresse.read', 'adresse.write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $strasse = null;

    #[Groups(['adresse.read', 'adresse.write'])]
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $plz = null;

    #[Groups(['adresse.read', 'adresse.write'])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ort = null;

    #[Groups(['adresse.read', 'adresse.write'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "bundesland", referencedColumnName:"kuerzel", nullable: true)]
    private ?Bundesland $bundesland = null;

    #[ORM\OneToMany(mappedBy: 'adresse', targetEntity: KundeAdresse::class)]
    private Collection $kundeAdresses;


    public function __construct()
    {
        $this->kundeAdresses = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(?Bundesland $bundesland): self
    {
        $this->bundesland = $bundesland;

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
            $kundeAdress->setAdresse($this);
        }

        return $this;
    }

    public function removeKundeAdress(KundeAdresse $kundeAdress): self
    {
        if ($this->kundeAdresses->removeElement($kundeAdress)) {
            // set the owning side to null (unless already changed)
            if ($kundeAdress->getAdresse() === $this) {
                $kundeAdress->setAdresse(null);
            }
        }

        return $this;
    }
}
