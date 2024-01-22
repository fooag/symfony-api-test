<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Address;
use App\Entity\Customer;
use App\Repository\AddressRepositoryInterface;
use App\Repository\CustomerAddressRepositoryInterface;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\SecurityBundle\Security;

class AddressStateProvider implements ProviderInterface
{
    public function __construct(
        private CustomerAddressRepositoryInterface $customerAddressRepository,
        private AddressRepositoryInterface $addressRepository,
        private Security $security,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();
        if (null === $user) {
            return null;
        }

        /** @var Customer[] $customers */
        $customers = $user->getVermittler()->getKunden();
        $customerIds = [];
        foreach ($customers as $customer) {
            $customerIds[] = $customer->getId();
        }

        $addressCollection = $this->customerAddressRepository->findAllByCustomerIds($customerIds);
        $expression = Criteria::expr()->in('adresseId', $addressCollection->map(function (Address $address): int {
            return $address->getAdresseId();
        })->toArray());
        return $this->addressRepository->matching(new Criteria($expression));
    }
}
