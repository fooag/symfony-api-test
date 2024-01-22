<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Customer;
use App\Repository\CustomerAddressRepositoryInterface;

class CustomerStateProvider implements ProviderInterface
{
    public function __construct(
        private ItemProvider $itemProvider,
        private CustomerAddressRepositoryInterface $customerAddressRepository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var Customer $customer */
        $customer = $this->itemProvider->provide($operation, $uriVariables, $context);

        $addressCollection = $this->customerAddressRepository->findAllByCustomerId($customer->getId());
        $customer->setAdressen($addressCollection);

        return $customer;
    }
}
