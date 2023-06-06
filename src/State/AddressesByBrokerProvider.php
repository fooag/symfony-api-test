<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use App\Repository\CustomerAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Contracts\Service\Attribute\Required;

class AddressesByBrokerProvider extends AbstractSessionProvider
{
    private CustomerAddressRepository $customerAddressRepository;

    #[Required]
    public function setCustomerAddressRepository(CustomerAddressRepository $customerAddressRepository): void
    {
        $this->customerAddressRepository = $customerAddressRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $customers = $this->getCustomersByLoggedInBroker();

        //todo replace block by one query
        $references = $this->customerAddressRepository->findBy(['customer' => $customers?->getValues(), 'deleted' => false]);
        $addresses = new ArrayCollection();
        foreach ($references as &$reference) {
            $addresses->add($reference->getAddress());
        }

        return $addresses;
    }
}
