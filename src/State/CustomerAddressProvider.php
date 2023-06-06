<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\AddressRepository;
use App\Repository\CustomerAddressRepository;
use App\Repository\CustomerRepository;

class CustomerAddressProvider implements ProviderInterface
{
    public function __construct(
        private readonly CustomerAddressRepository $customerAddressRepository,
        private readonly AddressRepository $addressRepository,
        private readonly CustomerRepository $customerRepository,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        //todo write one join query instead of three findOneBy
        $customer = $this->customerRepository->findOneBy(['id' => $uriVariables['customerId']]);
        $addresses = $this->addressRepository->findOneBy(['id' => $uriVariables['addressId']]);
        return $this->customerAddressRepository->findOneBy([
            'customer' => $customer,
            'address' => $addresses,
            'deleted' => false
        ]);
    }
}
