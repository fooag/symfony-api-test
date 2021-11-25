<?php

declare(strict_types=1);

namespace App\Entity\Std;

use Doctrine\ORM\Mapping as ORM;

/**
 * db model entity representation for an agent
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Entity\Std
 * @version   1.0.0
 * @since     1.0.0
 *
 * @ORM\Table(name="vermittler", schema="std")
 * @ORM\Entity(repositoryClass="App\Repository\Std\AgentRepository")
 */
class Agent
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected string $id;

    /**
     * @ORM\Column(type="string", name="nummer")
     */
    protected string $number;

    /**
     * @ORM\Column(type="string", name="vorname")
     */
    protected string $firstName;

    /**
     * @ORM\Column(type="string", name="nachname")
     */
    protected string $lastName;

    /**
     * @ORM\Column(type="string", name="firma")
     */
    protected string $company;

    /**
     * @ORM\Column(type="boolean", name="geloescht", nullable=false)
     */
    protected bool $isDeleted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Std\Customer", mappedBy="agent", orphanRemoval=false, cascade={"persist"})
     */
    protected array $customerCollection;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return \App\Entity\Std\Agent
     */
    public function setId($id): Agent
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return Agent
     */
    public function setNumber(string $number): Agent
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return \App\Entity\Std\Agent
     */
    public function setFirstName(?string $firstName): Agent
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return \App\Entity\Std\Agent
     */
    public function setLastName(?string $lastName): Agent
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string $company
     *
     * @return \App\Entity\Std\Agent
     */
    public function setCompany(?string $company): Agent
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     *
     * @return \App\Entity\Std\Agent
     */
    public function setIsDeleted(bool $isDeleted): Agent
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }
}
