<?php

declare(strict_types=1);

namespace App\Entity\Std;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * db model entity representation for an agent
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Entity\Std
 * @version   1.0.0
 * @since     1.0.0
 *
 * @ORM\Table(name="tbl_kunden", schema="std")
 * @ORM\Entity(repositoryClass="App\Repository\Std\CustomerRepository")
 */
class Customer
{
    const GENDER_COLLECTION = ['männlich', 'weiblich', 'divers'];

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected string $id;

    /**
     * @Assert\NotBlank(message="customer last name have to be filled")
     *
     * @ORM\Column(type="string", name="name")
     */
    protected string $lastName;

    /**
     * @Assert\NotBlank(message="customer first name have to be filled")
     *
     * @ORM\Column(type="string", name="vorname")
     */
    protected string $firstName;

    /**
     * @ORM\Column(type="string", name="firma")
     */
    protected string $company;

    /**
     * @ORM\Column(type="datetime", name="geburtsdatum", columnDefinition="timestamp default current_timestamp")
     */
    protected \DateTime $dateOfBirth;

    /**
     * @ORM\Column(type="boolean", name="geloescht", nullable=false)
     */
    protected bool $isDeleted;

    /**
     * @Assert\Choice(choices=Customer::GENDER_COLLECTION, message="gender has to be one of männlich, weiblich, divers")
     *
     * @ORM\Column(type="string", name="geschlecht")
     */
    protected string $gender;

    /**
     * @Assert\Email(message="inavlid email address")
     *
     * @ORM\Column(type="string", name="email")
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", name="vermittler_id")
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Std\Agent", inversedBy="customerCollection", cascade={"persist"})
     * @ORM\JoinColumn(name="vermittler_id", referencedColumnName="id")
     */
    protected Agent $agent;

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
     * @return Customer
     */
    public function setId(string $id): Customer
    {
        $this->id = $id;
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
     * @return Customer
     */
    public function setLastName(?string $lastName): Customer
    {
        $this->lastName = $lastName;
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
     * @return Customer
     */
    public function setFirstName(?string $firstName): Customer
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     *
     * @return Customer
     */
    public function setCompany(?string $company): Customer
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime|null $dateOfBirth
     *
     * @return \App\Entity\Std\Customer
     */
    public function setDateOfBirth(?\DateTime $dateOfBirth): Customer
    {
        $this->dateOfBirth = $dateOfBirth;
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
     * @return Customer
     */
    public function setIsDeleted(bool $isDeleted): Customer
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     *
     * @return \App\Entity\Std\Customer
     */
    public function setGender(?string $gender): Customer
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return \App\Entity\Std\Customer
     */
    public function setEmail(?string $email): Customer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return \App\Entity\Std\Agent
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @param \App\Entity\Std\Agent $agent
     *
     * @return \App\Entity\Std\Customer
     */
    public function setAgent(Agent $agent): Customer
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * @Assert\IsTrue(message="password is not safe")
     *
     * @return bool
     */
    public function isPasswordSafe(): bool
    {
        return $this->firstName != $this->lastName;
    }
}
