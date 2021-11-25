<?php

declare(strict_types=1);

namespace App\Service\UserBundle;

use App\Entity\Std\Agent;
use App\Entity\Std\Customer;

/**
 * mapper service to map an entity to plain data array
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Service\UserBundle
 * @version   1.0.0
 * @since     1.0.0
 */
class CustomerMapper
{
    /**
     * map a collection of entities for the customer api
     *
     * @param array $customerCollection
     *
     * @return array
     */
    public function mapCustomerEntityCollection(array $customerCollection): array
    {
        $dataCollection = [];
        foreach ($customerCollection as $customer) {
            $dataCollection[] = $this->mapCustomerEntity($customer);
        }

        return $dataCollection;
    }

    /**
     * map the customer entity to the data array for the customer api
     *
     * @param \App\Entity\Std\Customer $customer
     *
     * @return array
     */
    public function mapCustomerEntity(Customer $customer): array
    {
        return [
            'id' => $customer->getId(),
            'name' => $customer->getLastName(),
            'vorname' => $customer->getFirstName(),
            'geburtsdatum' => (($customer->getDateOfBirth() !== null) ? $customer->getDateOfBirth()->format('Y-m-d') : null),
            'geschlecht' => $customer->getGender(),
            'email' => $customer->getEmail(),
            'vermittlerId' => (($customer->getAgent() !== null) ? $customer->getAgent()->getId() : null),
            'adressen' => [],
            'user' => [
                'username' => $customer->getEmail(),
                'aktiv' => $customer->getIsDeleted(),
                'lastLogin' => null,
            ],
        ];
    }

    /**
     * map the api data for a customer creation to a new customer
     *
     * @param array $data
     * @param \App\Entity\Std\Agent $agent
     *
     * @return \App\Entity\Std\Customer
     */
    public function mapCustomerCreateDataToEntity(array $data, ?Agent $agent): Customer
    {
        $dateOfBirth = null;
        if (trim($data['geburtsdatum']) !== '') {
            $dateOfBirth = \DateTime::createFromFormat('Y-m-d', trim($data['geburtsdatum']));
        }

        $customer = new Customer();
        $customer->setLastName(trim($data['name']))
            ->setFirstName(trim($data['vorname']))
            ->setDateOfBirth($dateOfBirth)
            ->setIsDeleted(true)
            ->setGender(trim($data['geschlecht']))
            ->setEmail(trim($data['email']))
            ->setAgent($agent);

        return $customer;
    }
}
