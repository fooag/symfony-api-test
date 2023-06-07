<?php
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CustomerAddressRepository;
use App\Service\BrokerSessionService;
use Doctrine\Common\Collections\ArrayCollection;

class AddressesByBrokerProvider implements ProviderInterface
{

    public function __construct(
        private readonly BrokerSessionService $brokerSessionService,
        private readonly CustomerAddressRepository $customerAddressRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $customers = $this->brokerSessionService->getCustomersByLoggedInBroker();

        //todo replace block by one query
        $references = $this->customerAddressRepository->findBy(['customer' => $customers?->getValues(), 'deleted' => false]);
        $addresses = new ArrayCollection();
        foreach ($references as &$reference) {
            $addresses->add($reference->getAddress());
        }

        return $addresses;
    }
}
