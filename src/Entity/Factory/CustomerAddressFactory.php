<?php

declare(strict_types=1);

namespace App\Entity\Factory;

use App\Entity\CustomerAddress;

class CustomerAddressFactory
{
    public static function createCustomerAddress(array $data): CustomerAddress
    {
        $entity = new CustomerAddress();
        $entity->setKundeId($data['kunde_id']);
        $entity->setRechnugsadresse($data['rechnungsadresse']);
        $entity->setGeschaeftlich($data['geschaeftlich']);
        return $entity;
    }
}
